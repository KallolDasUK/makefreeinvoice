<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();

    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->user();


        $isUserExits = User::query()->where('email', $user->email)->first();
        if (!$isUserExits) {
            $isUserExits = User::create(['name' => $user->name ?? '', 'email' => $user->email, 'password' => \Hash::make(\Str::random(8))]);
        }
        Auth::login($isUserExits);

        return Redirect::route('acc.home');
    }
}
