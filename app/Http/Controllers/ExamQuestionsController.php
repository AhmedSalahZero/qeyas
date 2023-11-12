<?php

namespace App\Http\Controllers;

use App\Actions\ExamQuestions;
use App\Answer;
use App\Exam;
use App\ExamQuestion;
use App\ExamSection;
use App\Question;
use App\QuestionOption;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\VoyagerBaseController;
use TCG\Voyager\Traits\AlertsMessages;

class ExamQuestionsController extends Controller
{

    use AlertsMessages;

    public function create(Exam $exam) {
		if(!auth()->user()->is_admin()&&$exam->available){
			abort(403);
		}
		
        $sections = ExamSection::where('exam_id', $exam->id)->orderBy('section_order', 'asc')->get();
        return view('vendor.voyager.exams.questions.add', compact('exam', 'sections'));
    }

    public function remove(Request $request) {
        // Check permission
        // $this->authorize('browse_media');

        try {
            // GET THE SLUG, ex. 'posts', 'pages', etc.
            $slug = $request->get('slug');

            // GET file name
            $filename = $request->get('filename');

            // GET record id
            $id = $request->get('id');

            // GET field name
            $field = $request->get('field');

            // GET multi value
            $multi = $request->get('multi');

            // GET THE DataType based on the slug
            $dataType = \Voyager::model('DataType')->where('slug', '=', $slug)->first();

            // Check permission
            // $this->authorize('delete', app($dataType->model_name));

            // Load model and find record
            $model = app($dataType->model_name);
            $data = $model::find([$id])->first();

            // Check if field exists
            if(! isset($data->{$field})) {
                throw new Exception(__('voyager::generic.field_does_not_exist'), 400);
            }

            if(@json_decode($multi)) {
                // Check if valid json
                if(is_null(@json_decode($data->{$field}))) {
                    throw new Exception(__('voyager::json.invalid'), 500);
                }

                // Decode field value
                $fieldData = @json_decode($data->{$field}, true);
                $key = null;

                // Check if we're dealing with a nested array for the case of multiple files
                if(is_array($fieldData[0])) {
                    foreach($fieldData as $index => $file) {
                        $file = array_flip($file);
                        if(array_key_exists($filename, $file)) {
                            $key = $index;
                            break;
                        }
                    }
                } else {
                    $key = array_search($filename, $fieldData);
                }

                // Check if file was found in array
                if(is_null($key) || $key === false) {
                    throw new Exception(__('voyager::media.file_does_not_exist'), 400);
                }

                // Remove file from array
                unset($fieldData[$key]);

                // Generate json and update field
                $data->{$field} = empty($fieldData) ? null : json_encode(array_values($fieldData));
            } else {
                $data->{$field} = null;
            }

            $data->save();

            return response()->json([
                'data' => [
                    'status' => 200,
                    'message' => __('voyager::media.file_removed'),
                ],
            ]);
        } catch(Exception $e) {
            $code = 500;
            $message = __('voyager::generic.internal_error');

            if($e->getCode()) {
                $code = $e->getCode();
            }

            if($e->getMessage()) {
                $message = $e->getMessage();
            }

            return response()->json([
                'data' => [
                    'status' => $code,
                    'message' => $message,
                ],
            ], $code);
        }
    }

    public function show(Exam $exam) {
//        dd($exam->questions->first()->options);
        return view('vendor.voyager.exams.questions.index', compact('exam'));
    }

    public function delete(ExamQuestion $question) {
		// $this->authorize('delete',$question);
        $question->delete();
        return back();
    }

    public function update(Request $request, ExamQuestion $question) {


$this->validate($request, [
	'question_text' => isset($question->question_img) ? 'string|nullable' : 'required|string',
	'question_img' => 'image|nullable',
	'option_text.*' => 'string|nullable',
	'option_img.*' => 'image|nullable',
]);
$question->question_text = $request->question_text;
$question->explanation = $request->explanation;
$question->paragraph = $request->paragraph;
        $question->section_id = $request->section_id;
        if(isset($request->question_img)) {
			if(isset($question->question_img)) {
                unset($question->question_img);
            }
            $img = $request->file('question_img');
            $slug = 'exam-questions';
            $fullFilename = null;
            $resizeWidth = 1800;
            $resizeHeight = null;
            $path = $slug . '/' . date('F') . date('Y') . '/';

            $filename = basename(time(), '.' . $img->getClientOriginalExtension());
            $filename_counter = 1;
            while(Storage::disk(config('voyager.storage.disk'))->exists($path . $filename . '.' . $img->getClientOriginalExtension())) {
                $filename = basename(time(), '.' . $img->getClientOriginalExtension()) . (string) ($filename_counter++);
            }
            $fullPath = $path . $filename . '.' . $img->getClientOriginalExtension();
            $image = Image::make($img)
                ->resize($resizeWidth, $resizeHeight, function(Constraint $constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            $image->encode($img->getClientOriginalExtension(), 75);
            if(Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $image, 'public')) {
                $question->question_img = $fullPath;
            }
        }

        if(isset($request->option_text)) {
//            for($i=0; $i < count($request->option_text); $i++) {
//                if(isset($question->options[$i])){
//                    $question->options[$i]->option_text = $request->option_text[$i];
//                }
//            }
            foreach($request->option_text as $index => $txt) {
                if(isset($question->options[$index])) {
                    $question->options[$index]->option_text = $txt;
                } else {
                    if(! empty($txt)) {
                        $question->options[$index] = new QuestionOption;
                        $question->options[$index]->question_id = $question->id;
                        $question->options[$index]->option_text = $txt;
                    }
                }
            }
        }

        if($images = $request->file('option_img')) {
            foreach($images as $index => $image) {
                $slug = 'question-options';
                $fullFilename = null;
                $resizeWidth = 1800;
                $resizeHeight = null;
                $path = $slug . '/' . date('F') . date('Y') . '/';

                $filename = basename(time(), '.' . $image->getClientOriginalExtension());
                $filename_counter = 1;
                while(Storage::disk(config('voyager.storage.disk'))->exists($path . $filename . '.' . $image->getClientOriginalExtension())) {
                    $filename = basename(time(), '.' . $image->getClientOriginalExtension()) . (string) ($filename_counter++);
                }
                $fullPath = $path . $filename . '.' . $image->getClientOriginalExtension();
                $_image = Image::make($image)
                    ->resize($resizeWidth, $resizeHeight, function(Constraint $constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                $_image->encode($image->getClientOriginalExtension(), 75);
                if(Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $_image, 'public')) {
                    if(isset($question->options[$index])) {
                        if(isset($question->options[$index]->option_img)) {
                            unset($question->options[$index]->option_img);
                        }
                        $question->options[$index]->option_img = $fullPath;
                    } else {
                        $question->options[$index] = new QuestionOption;
                        $question->options[$index]->question_id = $question->id;
                        $question->options[$index]->option_img = $fullPath;
                    }
                } else {
                    $status = __('voyager::media.error_uploading');
                }
            }
        }
        if(isset($request->is_correct)) {
            $question->options->each(function($option) {
                if($option->is_correct) {
                    $option->is_correct = 0;
                }
            });
            $question->options->find($request->is_correct)->is_correct = 1;
            $question->right_answer_id = $request->is_correct;
        }
        $question->options->each->save();
		// dd($question,$request->question_text);
        $question->save();
        return redirect()->route('admin.exam_questions.show', $question->exam_id)->with($this->alertSuccess('تم التعديل بنجاح'));

    }

    public function edit(ExamQuestion $question) {
//        dd($question->options);
        return view('vendor.voyager.exams.questions.edit', compact('question'));
    }

    public function destroy_answer(QuestionOption $answer) {
        $answer->delete();
        return back()->with($this->alertSuccess('تم حذف الاجابة بنجاح'));
    }


    public function store(Request $request) {
//        dd($request->all());
        $this->validate($request,
            [
                'array' => 'required|array',
                'array.*.question_text' => 'required_without:array.*.question_image',
                'array.*.question_image' => 'required_without:array.*.question_text|nullable|image',
                'array.*.answer' => 'required',
                'array.*.options.*.answer_text' => 'required_without:array.*.options.*.answer_image',
                'array.*.options.*.answer_image' => 'required_without:array.*.options.*.answer_text|nullable|image',
                'exam' => 'required|exists:exams,id',
                'section_id' => 'required|exists:exam_sections,id'
            ],
            [
                'section_id.required' => 'عفواً,قسم الإمتحان مطلوب',
                'array.*.question_text.required_without' => 'عفواً,نص السؤال مطلوب',
                'array.*.answer.required' => 'عفواً,حدد إجابة السؤال',
                'array.*.options.*.answer_text.required_without' => 'عفواً,إجابة السؤال مطلوب',
                'array.*.options.*.answer_image.required_without' => 'عفواً,إجابة السؤال مطلوب',
            ]
        );


        foreach($request->array as $array) {

            $question = new Question();
            $question->exam_id = $request->exam;
            $question->section_id = $request->section_id;
            $question->question_text = $array['question_text'];
            $question->explanation = $array['explanation'];
            $question->paragraph = $array['paragraph'];
            if(isset($array['question_image'])) {
                $image = $array['question_image'];
                $slug = 'question-image';
                $fullFilename = null;
                $resizeWidth = 1800;
                $resizeHeight = null;
                $path = $slug . '/' . date('F') . date('Y') . '/';

                $filename = basename(time(), '.' . $image->getClientOriginalExtension());
                $filename_counter = 1;
                while(Storage::disk(config('voyager.storage.disk'))->exists($path . $filename . '.' . $image->getClientOriginalExtension())) {
                    $filename = basename(time(), '.' . $image->getClientOriginalExtension()) . (string) ($filename_counter++);
                }
                $fullPath = $path . $filename . '.' . $image->getClientOriginalExtension();
                $_image = Image::make($image)
                    ->resize($resizeWidth, $resizeHeight, function(Constraint $constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                $_image->encode($image->getClientOriginalExtension(), 75);
                if(Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $_image, 'public')) {
                    $status = __('voyager::media.success_uploading');
                    $question->question_img = $fullPath;
                } else {
                    $status = __('voyager::media.error_uploading');
                }
            }
            $question->save();

            $right_answer_index = $array['answer'];
            $right_answer = $array['options'][$right_answer_index];

            foreach($array['options'] as $option) {
                $answer = new Answer();
                $answer->question_id = $question->id;
                $answer->option_text = $option['answer_text'];
                if($option['answer_text'] == $right_answer['answer_text']) $answer->is_correct = 1;
                if(isset($option['answer_image'])) {
                    $image = $option['answer_image'];
                    $slug = 'question-image';
                    $fullFilename = null;
                    $resizeWidth = 1800;
                    $resizeHeight = null;
                    $path = $slug . '/' . date('F') . date('Y') . '/';

                    $filename = basename(time(), '.' . $image->getClientOriginalExtension());
                    $filename_counter = 1;
                    while(Storage::disk(config('voyager.storage.disk'))->exists($path . $filename . '.' . $image->getClientOriginalExtension())) {
                        $filename = basename(time(), '.' . $image->getClientOriginalExtension()) . (string) ($filename_counter++);
                    }
                    $fullPath = $path . $filename . '.' . $image->getClientOriginalExtension();
                    $_image = Image::make($image)
                        ->resize($resizeWidth, $resizeHeight, function(Constraint $constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    $_image->encode($image->getClientOriginalExtension(), 75);
                    if(Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $_image, 'public')) {
                        $status = __('voyager::media.success_uploading');
                        $answer->option_img = $fullPath;
                    } else {
                        $status = __('voyager::media.error_uploading');
                    }
                }
                $answer->save();

                if($answer->is_correct == 1) {
                    $question->right_answer_id = $answer->id;
                    $question->save();
                }
            }
        }

        return redirect()->route('admin.exam_questions.create', $request->exam)->with($this->alertSuccess('تمت الاضافة بنجاح'));
    }
}
