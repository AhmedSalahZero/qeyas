<?php

namespace App\Http\Controllers;

use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Constraint;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile() {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit() {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request) {
//        dd($request->all());
        $user = Auth::user();
        $this->validate($request, [
            'name' => 'required|string',
            'phone' => 'required|unique:users,phone,' . $user->id . ',id',
            'email' => 'required|email',
            'gender' => 'required',
            'user_photo' => 'nullable|image',
            'city' => 'nullable|exists:cities,id',
            'education' => 'nullable|numeric'
        ],
            ['user_photo.image' => 'ملف الصورة غير صالح'],
            ['gender' => 'النوع', 'city' => 'المدينة']
        );

        // Image Upload
        if($request->hasFile('user_photo')) {
            $img = $request->file('user_photo');
            $slug = 'users';
            $resizeWidth = 1800;
            $resizeHeight = null;
            $path = $slug . '/' . date('F') . date('Y') . '/';

            $filename = basename($img->getClientOriginalName(), '.' . $img->getClientOriginalExtension());
            $filename_counter = 1;
            while(Storage::disk(config('voyager.storage.disk'))->exists($path . $filename . '.' . $img->getClientOriginalExtension())) {
                $filename = basename($img->getClientOriginalName(), '.' . $img->getClientOriginalExtension()) . (string) ($filename_counter++);
            }
            $fullPath = $path . $filename . '.' . $img->getClientOriginalExtension();
            $image = Image::make($img)
                ->resize($resizeWidth, $resizeHeight, function(Constraint $constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            $image->encode($img->getClientOriginalExtension(), 75);
            if(Storage::disk(config('voyager.storage.disk'))->put($fullPath, (string) $image, 'public')) {
                $user->avatar = $fullPath;
            }
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->city = $request->city;
        $user->education_level = $request->education;
        $user->save();

        UserNotification::create([
            'type' => 'private',
            'user_id' => $user->id,
            'content' => 'تم تعديل بيانات الحساب بنجاح'
        ]);

        return redirect()->route('user.profile')->with('message', 'تم تعديل بيانات الحساب بنجاح');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update_password(Request $request) {
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);
        $user = Auth::user();
        $current_password = $request->current_password;
        if(! Hash::check($current_password, $user->password)){
            return back()->with('message', 'كلمة المرور الحالية التي ادخلتها غير صحيحة');
        }
        $user->password = Hash::make($request->password);
        $user->password_changed = 1;
        $user->save();

        UserNotification::create([
            'type' => 'private',
            'user_id' => $user->id,
            'content' => 'تم تعديل كلمة المرور بنجاح'
        ]);
        return back()->with('message', 'تم تغيير كلمة المرور بنجاح');
    }

    public function notifications() {
        $title = 'الاشعارات';
        $notifications = Auth::user()->user_notifications;
        return view('user.notifications', compact('title', 'notifications'));
    }
}
