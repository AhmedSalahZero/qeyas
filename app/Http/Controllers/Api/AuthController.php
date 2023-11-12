<?php

namespace App\Http\Controllers\Api;

use App\City;
use App\Code;
use App\Education;
use App\Exam;
use App\ExamRequest;
use App\ExamTry;
use App\User;
use App\UserNotification;
use App\UserToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use TCG\Voyager\Facades\Voyager;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'phone' => 'required',
                'gender' => 'sometimes|in:m,f',
                'city' => 'required|exists:cities,id',
                'education_level' => 'required|exists:educations,id',
                'password' => 'required',
                'token' => 'sometimes'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $phone_check = User::where('phone', $request->phone)->first();
        if($phone_check) return response()->json(['status' => 'error', 'msg' => 'phone exists']);

        $request->merge(
            [
                'password' => Hash::make($request->password)
            ]
        );


        $user = User::create($request->all());
        $user['city_name'] = isset($user->city) ? City::where('id', $user->city)->first()->city_name : '';
        $user['education_level'] = (integer) $user->education_level;
        $user['education_name'] = isset($user->education_level) ? Education::where('id', $user->education_level)->first()->name : '';
        $user['avatar_api'] = $user->fresh()->avatar;

        unset($user->avatar);

        if($request->token)
        {
            UserToken::updateOrcreate
            (
                [
                    'user_id' => $user->id,
                    'token' => $request->token
                ]
            );
        }


        return response()->json(['status' => 'success', 'msg' => 'registered', 'user' => $user]);
    }


    public function social_login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'platform' => 'required|in:facebook,twitter,snapchat',
                'social_id' => 'required',
                'avatar' => 'sometimes',
                'name' => 'required',
                'token'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        if($request->avatar == '') $request->merge(['avatar' => 'users/default.png']);

        User::updateOrcreate
        (
            [
                'platform' => $request->platform,
                'social_id' => $request->social_id
            ],
            [
                'name' => $request->name,
                'avatar' => $request->avatar
            ]
        );

        $user = User::where('social_id',$request->social_id)->where('platform',$request->platform)->select('id','social_id','name','phone','city','education_level','avatar as avatar_api','password')->first();

        $user['city_name'] = $user->city != '' ? City::where('id', $user->city)->first()->city_name : '';
        $user['education_name'] = $user->education_level != '' ? Education::where('id', $user->education_level)->first()->name : '';
//        $user['avatar_api'] = $user->getOriginal('avatar');

//        unset($user->avatar);

        if($request->token)
        {
            UserToken::updateOrcreate
            (
                [
                    'user_id' => $user->id,
                    'token' => $request->token
                ]
            );
        }

        return response()->json(['status' => 'success', 'msg' => 'logged in', 'user' => $user]);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'phone' => 'required',
                'password' => 'required',
                'token' => 'sometimes',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }


        $user = User::where('phone',$request->phone)->select('id','social_id','name','phone','city','education_level','avatar as avatar_api','gender','password')->first();

        if($user)
        {
            $check = Hash::check($request->password,$user->password);

            if($check)
            {
                if($user->social_id != null)
                {
                    $user['avatar_api'] = $user->getOriginal('avatar');
                }

                unset($user->social_id);

                $user['city_name'] = isset($user->city) ? City::where('id', $user->city)->first()->city_name : '';
                $user['education_name'] = isset($user->education_level) ? Education::where('id', $user->education_level)->first()->name : '';


                if($request->token)
                {
                    UserToken::updateOrcreate
                    (
                        [
                            'user_id' => $user->id,
                            'token' => $request->token
                        ]
                    );
                }

                unset($user->password);
                return response()->json(['status' => 'success', 'msg' => 'logged in', 'user' => $user]);
            }
            else
            {
                return response()->json(['status' => 'error', 'msg' => 'invalid password']);
            }
        }
        else
        {
            return response()->json(['status' => 'error', 'msg' => 'invalid phone']);
        }
    }


    public function token_update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'token' => 'sometimes',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        if($request->token)
        {
            UserToken::updateOrcreate
            (
                [
                    'user_id' => $request->user_id,
                    'token' => $request->token
                ]
            );
        }

        return response()->json(['status' => 'success', 'msg' => 'updated']);
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
//                'name' => 'required',
                'phone' => 'required',
                'gender' => 'sometimes|in:m,f',
                'city' => 'required|exists:cities,id',
                'education_level' => 'required|exists:educations,id',
                'password' => 'sometimes',
                'avatar' => 'sometimes|image'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $phone_check = User::where('phone',$request->phone)->where('id','!=',$request->user_id)->first();

        if($phone_check) return response()->json(['status' => 'error','msg' => 'phone exists']);

        $this_user = User::where('id',$request->user_id)->select('id','name','phone','city','education_level','avatar','gender','password')->first();
            if($request->name ) $this_user->name = $request->name;
            $this_user->phone = $request->phone;
            if($request->gender) $this_user->gender = $request->gender;
            $this_user->city = $request->city;
            $this_user->education_level = $request->education_level;
                if($request->password) $this_user->password = Hash::make($request->password);
                if($request->avatar)
                {
                    $path = 'users/'.date('F').date('Y').'/';
                    $strip = str_replace(' ','-',$request->avatar->getClientOriginalname());
                    $image = time().uniqid().$strip;
                    $request->avatar->move(base_path().'/storage/app/public/'.$path,$path.$image);

                    $this_user->avatar = $path.$image;
                }
        $this_user->save();

        $user = User::where('id',$request->user_id)->select('id','name','phone','city','education_level','avatar as avatar_api','gender','password')->first();

        $user['city_name'] = isset($user->city) ? City::where('id', $user->city)->first()->city_name : '';
        $user['education_name'] = isset($user->education_level) ? Education::where('id', $user->education_level)->first()->name : '';

        unset($user->avatar);

        return response()->json(['status' => 'success', 'msg' => 'profile updated successfully', 'user' => $user]);
    }



    public function password_reset(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'phone' => 'required',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $phone_check = User::where('phone', $request->phone)->first();
        if(!$phone_check) return response()->json(['status' => 'error', 'msg' => 'phone exists']);

        Code::UpdateOrCreate
        (
            [
                'phone' => $request->phone
            ],
            [
                'code' => rand(1000,9999),
                'expire_at' => Carbon::now()->addHour()
            ]
        );

        return response()->json(['status' => 'success', 'msg' => 'code sent']);
    }


    public function code_check(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'code' => 'required'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        $phone = Code::where('code', $request->code)->where('expire_at','>=', Carbon::now())->first();

        if($phone)
        {
            $user = User::where('phone', $phone->phone)->select('id')->first();
            return response()->json(['status' => 'success', 'msg' => 'code matched', 'user' => $user]);
        }
        else
        {
            return response()->json(['status' => 'error', 'msg' => 'invalid code']);
        }

    }


    public function password_change(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'password' => 'required|min:6'
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        User::where('id', $request->user_id)->update
        (
            [
                'password' => Hash::make($request->password)
            ]
        );

        return response()->json(['status' => 'success', 'msg' =>'password updated successfully']);
    }


    public function notifications(Request $request)
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

        $user = User::where('id',$request->user_id)->select('gender','city','education_level','created_at')->first();

        $notifications = UserNotification::where('created_at','>=',$user->created_at)->where( function ($q) use ($user)
        {
            $q->where('user_id', $user->id);
            $q->orWhere('type','public');
            $q->orWhere('user_gender',$user->gender)->where('type','public');
            $q->orWhere('city_id',$user->city)->where('type','public');
            $q->orWhere('education_level',$user->education_level)->where('type','public');
        })->select('content','created_at')->latest()->paginate(50);

        return response()->json($notifications);
    }


    public function delete_request(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'exam_id' => 'required|exists:exams,id',
            ]
        );

        if($validator->fails())
        {
            return response()->json(['status' => 'error', 'msg' => $validator->getMessageBag()]);
        }

        ExamRequest::where('user_id', $request->user_id)->where('exam_id', $request->exam_id)->delete();

        return response()->json('deleted');
    }


    public function push_notify($user_id)
    {
        $tokens = UserToken::where('user_id',$user_id)->pluck('token');
        $notify  = UserNotification::send($tokens,'title','msg msg');

        dd($notify);
    }
}


