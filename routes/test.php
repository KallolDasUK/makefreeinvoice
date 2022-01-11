<?php

use App\Models\MetaSetting;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/app_1', function (\Illuminate\Http\Request $request) {
//  response()->withHeaders(['WWW-Authenticate' => 'Basic']);
//    dd($request->all());
//    header('WWW-Authenticate: Basic  realm="myRealm"');
//
    $users = User::query()->get();

    foreach ($users as $user) {
        MetaSetting::query()
            ->withoutGlobalScope('scopeClient')
            ->updateOrCreate(
                ['key' => 'plan_name', 'client_id' => $user->client_id],
                ['value' => 'Trial', 'client_id' => $user->client_id]);
//        dump($user->settings->plan_name ?? 'n/a', $user->email);
    }
    dd('done');
});








