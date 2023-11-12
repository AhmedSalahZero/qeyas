<?php

namespace App\Http\Controllers\Api;

use App\Adsense;
use App\Category;
use App\Exam;
use App\Question;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('cat_parent', 0)->orderBy('cat_order','asc')->select('id','cat_name','cat_order','cat_image as cat_image_api')->get();
        foreach($categories as $cat)
        {
            $cat['exams_count'] = $cat->exams_count($cat->id);
            $cat['is_last'] = $cat->is_last($cat->id);
        }

        $sliders = Adsense::where('ad_end_date','>=',Carbon::today()->toDateString())->where('active',1)->whereIn('show',['app','both'])->select('id','ad_name','ad_photo as ad_photo_api','ad_url')->get();

        return response()->json(['categories' => $categories, 'sliders' =>$sliders]);
    }


    public function sub_cats($id)
    {
        $categories = Category::where('cat_parent', $id)->orderBy('cat_order', 'asc')->select('id','cat_name','cat_order','cat_image as cat_image_api')->get();
        foreach($categories as $cat)
        {
            $cat['is_last'] = $cat->is_last($cat->id);
            if($cat->is_last == true)
            {
                $cat['exams_count'] = $cat->get_exams_count($cat->id);
            }
            else
            {
                $cat['exams_count'] = $cat->exams_count($cat->id);
            }
        }

        return response()->json($categories);
    }


    public function search(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required',
                'text' => 'sometimes',
                'cat_id' => 'sometimes|exists:categories,id'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $exams = Exam::where(function($q) use($request)
        {
            if($request->text) $q->where('title','like','%'.$request->text.'%');
            if($request->cat_id)
            {
                $arr[] = $request->cat_id;
                $subs = Category::where('cat_parent', $request->cat_id)->pluck('id');

                $all = array_merge($arr,$subs->toArray());
                $q->whereIn('category_id',$all);
            }
        }
        )->where('available', 1)->select('id','title','exam_type','exam_price','exam_duration')->paginate(20);

        foreach($exams as $exam)
        {
            $exam['questions'] = Question::where('exam_id', $exam->id)->count();
            $exam['is_purchased'] = $exam->is_purchased($exam->id,$request->user_id);
        }

        return response()->json($exams);
    }


    public function get_settings()
    {
        $arr = ['site.email','site.phone','site.facebook','site.twitter','site.instagram'];
        $settings = Setting::where('group','app')->orWhereIn('key',$arr)->select('key','display_name','value','details','type')->get();

        return response()->json($settings);
    }


    public function slider_watch(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'slider_id' => 'required|exists:adsense,id',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        Adsense::find($request->slider_id)->increment('num_views');

        return response()->json(['status' => 'success', 'msg' => 'views incremented successfully']);
    }
}
