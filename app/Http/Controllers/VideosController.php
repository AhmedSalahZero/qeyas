<?php

namespace App\Http\Controllers;

use App\Video;
use Illuminate\Http\Request;

class VideosController extends Controller
{

    public function index() {
        $videos = Video::whereActive(1)->where('course_id',null)->orderBy('id','desc')->paginate(10);
        $title = 'مكتبة الفيديو';
        return view('videos.index', compact('videos', 'title'));
    }

    public function show(Video $video) {
        if(! $video->active){
            return back()->with('message', 'هذا الفيديو غير متاح في الوقت الحالي');
        }
        $video->video_num_watches++;
        $video->save();
        $title = $video->video_title;
        return view('videos.show', compact('video', 'title'));
    }
}
