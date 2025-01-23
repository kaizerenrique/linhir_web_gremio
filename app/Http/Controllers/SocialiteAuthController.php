<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class SocialiteAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('discord')->redirect();
    }

    public function callback()
    {
        $providerUser = Socialite::driver('discord')->user();
        $user = User::where('email', $providerUser->getEmail())->first();
        
        //comprobar si el usuario está registrado
        if (!$user) {
            $user = User::create([
                'email' => $providerUser->getEmail(),
                'name' => $providerUser->getName(),
            ]);
        }

        $user->authProviders()->updateOrCreate([
            'provider' => 'discord',
        ], [
            'provider_id' => $providerUser->getId(),
            'avatar' => $providerUser->getAvatar(),
            'token' => $providerUser->token,
            'nickname' => $providerUser->getNickname(),
            'login_at' => Carbon::now(),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
        
    }

}
