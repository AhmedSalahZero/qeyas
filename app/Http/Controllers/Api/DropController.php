<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\City;
use App\Education;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DropController extends Controller
{
    public function get_categories()
    {
        $subs = [];
        $secs = [];

        $main_cats = Category::where('cat_parent', 0)->orderBy('cat_app_order','desc')->select('id','cat_name')->get();
        $others = Category::where('cat_parent', '!=',0)->select('id','cat_parent')->get();

        foreach($others as $other)
        {
            $children = Category::where('cat_parent', $other->id)->select('id')->get();

            if($children->count() > 0)
            {
                array_push($subs,$other->id);
            }
            else
            {
                array_push($secs,$other->id);
            }
        }

        $sub_cats = Category::whereIn('id', $subs)->orderBy('cat_app_order','desc')->select('id','cat_name')->get();
        $sec_cats = Category::whereIn('id', $secs)->orderBy('cat_app_order','desc')->select('id','cat_name')->get();


        return response()->json(['main_cats' => $main_cats,'sub_cats' => $sub_cats,'sec_cats' => $sec_cats]);
    }


    public function get_cities()
    {
        $data = City::select('id','city_name as name')->get();
        return response()->json($data);
    }


    public function get_educations()
    {
        $data = Education::select('id','name')->get();
        return response()->json($data);
    }
}
