<?php

namespace App\Http\Controllers\Api;

use App\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    public function header()
    {
        $data = News::where('active', 1)->select('id','content')->get();
        return response()->json($data);
    }


    public function all()
    {
        $news = News::where('active',1)->select('id','title','content as min_content','content','photo as photo_api','news_date as news_date_api','num_watches','likes','dislikes')->paginate(10);
        return response()->json($news);
    }


    public function vote(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id' => 'required|exists:qeyas_news',
                'property' => 'required|in:num_watches,likes,dislikes'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $x = $request->property;

        $count = News::find($request->id);
            $count->$x ++;
        $count->save();

        return response()->json(['status' => 'success', 'msg' => 'voted', 'count' => $count->$x]);
    }
}
