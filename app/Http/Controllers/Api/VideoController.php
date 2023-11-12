<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use mysql_xdevapi\Exception;

class VideoController extends Controller
{
    public function all()
    {
        $videos = Video::where('active',1)
		
		->select('id','video_title','video_url','video_description','video_num_watches','created_at')->paginate(20);

        foreach($videos as $video)
        {
            $yt_rx = '/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/';

            $id = explode('/',$video->video_url);

            try
            {
                $video['thumbnail'] = 'http://img.youtube.com/vi/'.$id[3].'/mqdefault.jpg';
            }
            catch (Exception $exception)
            {
                $video['thumbnail'] = 'http://qeyas2030.com/images/default-video-thumb.png';
            }

            $video['is_youtube'] = boolval(preg_match($yt_rx, $video->video_url, $yt_matches));
            $video['date'] = $video->created_at->toDateString();
            $video['share_link'] = $_SERVER['APP_URL'];

            unset($video->created_at);
        }

        return response()->json($videos);
    }


    public function watch(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'id' => 'required|exists:videos',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $count = Video::find($request->id);
            $count->video_num_watches++;
        $count->save();

        return response()->json(['status' => 'success', 'msg' => 'views incremented successfully', 'count' => $count->video_num_watches]);
    }
}
