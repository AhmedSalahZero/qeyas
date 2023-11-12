<?php

namespace App\Http\Controllers\Api;

use App\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function contact_us(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
                'subject' => 'required',
                'message' => 'required'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        ContactUs::create($request->all());

        return response()->json(['status' => 'success', 'msg' => 'message send successfully']);
    }
}

