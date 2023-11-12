<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{

    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param $provider
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider) {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Provider.
     *
     * @param $social
     * @return \Illuminate\Http\Response|\Exception
     */
    public function handleProviderCallback($social) {
        try {
            $user = $this->setOrGetUser(Socialite::driver($social));
            auth()->login($user, true);
            return redirect('/');
        } catch(\Exception $e) {
            return redirect('login')->with('failed', "فشل الدخول بواسطة  {$social}, من فضلك حاول مرة اخرى ");
        }
    }

    protected function setOrGetUser(Provider $provider) {
        $providerUser = $provider->user();
        $providerName = class_basename($provider);

        // get user by social id
        $user = User::whereSocialId($providerUser->getId())->first();
        if($user){
            return $user;
        }

        // get user by email
        $user = User::whereEmail($providerUser->getEmail())->first();
        if($user) {
            return $user;
        }

        // create user if not exist 
        $user = User::create([
            'email' => $providerUser->getEmail() ?? '',
            'name' => $providerUser->getName(),
            'platform' => $providerName,
            'social_id' => $providerUser->getId(),
            'password' => Hash::make($providerUser->getId()),
            'avatar' => $providerUser->getAvatar() ?? '',
        ]);

        return $user;
    }
}
