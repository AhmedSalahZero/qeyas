<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'r_phone' => ['required', 'unique:users,phone'],
            'gender' => 'required|in:m,f',
            'city' => ['nullable', 'exists:cities,id'],
            'r_password' => ['required', 'string', 'min:6', 'confirmed'],
        ],[],
            [
                'r_phone' => 'رقم الهاتف',
                'city' => 'المدينة',
                'r_password' => 'كلمة المرور',
                'r_password_confirmation' => 'تأكيد كلمة المرور',
                'gender' => 'النوع'
            ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'              => $data['name'],
            'email'             => $data['email'],
            'phone'             => $data['r_phone'],
            'gender'            => $data['gender'],
            'education_level'   => $data['education'],
            'city'              => $data['city'],
            'password'          => Hash::make($data['r_password']),
        ]);
    }

    protected function registered(Request $request, $user) {
        UserNotification::create([
            'user_id' => $user->id,
            'content' => 'تم التسجيل بنجاح',
        ]);
        return redirect($this->redirectPath());
    }


}
