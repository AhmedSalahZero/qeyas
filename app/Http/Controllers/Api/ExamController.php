<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Education;
use App\Exam;
use App\ExamReport;
use App\ExamRequest;
use App\ExamSection;
use App\ExamTry;
use App\ExamTryArchive;
use App\Http\Controllers\Controller;
use App\Question;
use App\User;
use Carbon\Carbon;
use function GuzzleHttp\Psr7\str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class ExamController extends Controller
{
    public function get_exams($cat_id,$user_id)
    {
        $exams = Exam::where('category_id', $cat_id)->where('available', 1)->select('id','lang','title','exam_type','exam_price','exam_duration')->paginate(20);

        foreach($exams as $exam)
        {
            $exam['questions'] = Question::where('exam_id', $exam->id)->count();
            $exam['is_purchased'] = $exam->is_purchased($exam->id,$user_id);
        }

        return response()->json($exams);
    }

	// subscribe to an exam
    public function get_exam(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'exam_id' => 'required|exists:exams,id'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $type = Exam::where('id', $request->exam_id)->select('exam_type')->first()->exam_type;

        if($type == 'paid')
        {
            $check = ExamRequest::where('user_id', $request->user_id)->where('exam_id', $request->exam_id)->where('status','approved')->first();

            if($check == null)
            {
                return response()->json(['status' => 'error', 'msg' => 'exam request not found']);
            }
        }
        else
        {
            ExamRequest::updateOrCreate
            (
                [
                    'user_id' => $request->user_id,
                    'exam_id' => $request->exam_id,
                    'status' => 'approved'
                ]
            );
        }

        $sections = ExamSection::where('exam_id', $request->exam_id)->count();
        $questions = Question::where('exam_id', $request->exam_id)->select('id','section_id','question_text as question','question_img as image_api','right_answer_id','paragraph')->get();

        foreach($questions as $question)
        {
            $q_no_tags = strip_tags($question->question,'<p>');
            $question['q_html'] = ($question->question != $q_no_tags) ? true : false ;
            $p_no_tags = strip_tags($question->paragraph,'<p>');
            $question['p_html'] = ($question->paragraph != $p_no_tags) ? true : false ;

            $question['section'] = $question->get_section($question->section_id);
            $question['sections_count'] = $sections;
            $question['answers'] = $question->get_answers($question->id);

            unset($question->section_id);
        }

        return response()->json($questions);
    }


    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id|exists:exam_requests,user_id,status,approved,exam_id,'.$request->exam_id,
                'exam_id' => 'required|exists:exams,id',
                'time_spent' => 'required',
                'num_passed_questions' => 'required',
                'num_failed_questions' => 'required',
                'answers' => 'required',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }


        $check = Question::where('exam_id', $request->exam_id)->count();
        $total = $request->num_passed_questions + $request->num_failed_questions;

        if($check != $total)
        {
            return response()->json(['status' => 'error', 'msg' => 'questions count is invalid']);
        }

        $total = $request->num_passed_questions + $request->num_failed_questions;
        $request->merge
        (
            [
                'result' => $request->num_passed_questions.'/'.$total,
                'percentage' => round($request->num_passed_questions / $total * 100)
            ]
        );

        $try = ExamTry::create($request->except('answers'));

        foreach(explode('|',$request->answers) as $answer)
        {
            $answer = explode(',',$answer);

            ExamTryArchive::create
            (
                [
                    'try_id' => $try->id,
                    'question_id' => $answer[0],
                    'answer_id' => $answer[1],
                    'right_answer_id' => $answer[2],
                ]
            );
        }

        return response()->json(['status' => 'success', 'msg' => 'entry submitted successfully']);
    }


    public function previous_attempts(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $ids = ExamTry::where('user_id', $request->user_id)->pluck('exam_id');

        $exams = Exam::whereIn('id', $ids)->select('id','lang','title')->get();

        foreach($exams as $exam)
        {
            $attempts = ExamTry::where('user_id', $request->user_id)->where('exam_id', $exam->id);

            $times = $attempts->pluck('time_spent');
            $total = 0;

            foreach ($times as $time)
            {
                $explode = explode(':',$time);

                $seconds = $explode[0] * 60 *60;
                $seconds += $explode[1] * 60;
                $seconds += $explode[2];

                $total += $seconds;
            }

            $exam['highest_result'] = $attempts->orderBy('percentage','desc')->first()->result;
            $exam['percentage'] = $attempts->orderBy('percentage','desc')->first()->percentage;
            $exam['count'] = $attempts->count();
            $exam['total_spent'] = gmdate('H:i:s', $total);
            $exam['latest'] = $attempts->latest()->first()->created_at->toDateTimeString();
        }

        return response()->json($exams);
    }


    public function get_attempts(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'exam_id' => 'required|exists:exams,id'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $attempts = ExamTry::where('user_id', $request->user_id)->where('exam_id', $request->exam_id)->select('id','result','percentage','time_spent','num_passed_questions','num_failed_questions','created_at as date')->orderBy('date','desc')->get();

        $total = 0;

        foreach ($attempts as $attempt)
        {
            $explode = explode(':',$attempt->time_spent);

            $seconds = $explode[0] * 60 *60;
            $seconds += $explode[1] * 60;
            $seconds += $explode[2];

            $total += $seconds;
        }


        $data['title'] = Exam::where('id', $request->exam_id)->select('title')->first()->title;
        $data['count'] = $attempts->count();
        $data['total_spent'] = gmdate('H:i:s', $total);
        if($attempts->count() > 0) $data['latest'] = $attempts->first()->date;
        else $data['latest'] = '';

        return response()->json(['data' => $data,'attempts' => $attempts]);
    }


    public function get_attempt_archive(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'attempt_id' => 'required|exists:exam_tries,id',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $questions = ExamTryArchive::where('try_id', $request->attempt_id)->select('question_id','answer_id','right_answer_id')->get();

        foreach($questions as $question)
        {
            $q_info = $question->get_question($question->question_id);

            $question['question'] = $q_info->question;
            $question['image_api'] = $q_info->image_api;
            $question['paragraph'] = $q_info->paragraph;
            $question['explanation'] = $q_info->explanation;

            $q_no_tags = strip_tags($q_info->question,'<p>');
            $question['q_html'] = ($q_info->question != $q_no_tags) ? true : false ;
            $p_no_tags = strip_tags($q_info->paragraph,'<p>');
            $question['p_html'] = ($q_info->paragraph != $p_no_tags) ? true : false ;
            $e_no_tags = strip_tags($q_info->explanation,'<p>');
            $question['e_html'] = ($q_info->explanation != $e_no_tags) ? true : false ;

            $question['section'] = $q_info->get_section($q_info->section_id);
            $question['answers'] = $question->get_answers($question->question_id);

            unset($question->question_id);
        }

        return response()->json($questions);
    }


    public function the_best(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'exam_id' => 'required|exists:exams,id',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }


        $bests = ExamTry::where('exam_id', $request->exam_id)->orderBy('percentage','desc')->select('user_id as user','result','time_spent','percentage')->paginate(20);
        $n = 1;

        foreach($bests as $best)
        {
            $best['order'] = $n;
            $best['user'] = $best->get_user($best->user);

            $n++;
        }

        return response()->json($bests);
    }
	
}
