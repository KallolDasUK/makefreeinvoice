<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use DB;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();

    }

    public function callback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();


        $isUserExits = User::query()->where('email', $user->email)->first();
        $needSeed = false;
        if (!$isUserExits) {
            $needSeed = true;
            $statement = DB::select("SHOW TABLE STATUS LIKE 'users'");
            $nextId = $statement[0]->Auto_increment;
            $isUserExits = User::create(['name' => $user->name ?? '', 'email' => $user->email, 'password' => \Hash::make(\Str::random(8)), 'client_id' => $nextId]);


        }
        Auth::login($isUserExits);
        if ($needSeed) {
            \Artisan::call('db:seed --class=AccountingSeeder');
            PaymentMethod::create(['name' => 'Cash']);
            PaymentMethod::create(['name' => 'Bank Transfer']);
            PaymentMethod::create(['name' => 'Credit Card']);
            PaymentMethod::create(['name' => 'Visa Card']);
        }

        return Redirect::route('acc.home');
    }
}
