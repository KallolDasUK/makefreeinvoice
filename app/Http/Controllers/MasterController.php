<?php

namespace App\Http\Controllers;

use App\Models\GlobalSetting;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index()
    {
        return view('master.index');
    }

    public function users()
    {
        $users = User::query()->orderBy('role', 'desc')->paginate(25);


        return view('master.users', compact('users'));
    }

    public function subscriptions()
    {
        $global_settings = json_decode(GlobalSetting::query()->pluck('value', 'key')->toJson());
        return view('master.subscriptions', compact('global_settings'));
    }


    public function freePlanSettings(Request $request)
    {
        $params = $request->all();
        GlobalSetting::query()->where('key', 'like', '%free_%')->update(['value' => false]);

        foreach ($params as $key => $value) {
            GlobalSetting::query()->updateOrCreate(['key' => 'free_' . $key], ['value' => $value]);
        }
        return back()->with('message', 'Free Plan Setting Saved');
    }

    public function basicPlanSettings(Request $request)
    {
        $params = $request->all();
        GlobalSetting::query()->where('key', 'like', '%basic_%')->update(['value' => false]);

        foreach ($params as $key => $value) {
            GlobalSetting::query()->updateOrCreate(['key' => 'basic_' . $key], ['value' => $value]);
        }
        return back()->with('message', 'Basic Plan Setting Saved');

    }

    public function premiumPlanSettings(Request $request)
    {
        $params = $request->all();
        GlobalSetting::query()->where('key', 'like', '%premium_%')->update(['value' => false]);

        foreach ($params as $key => $value) {
            GlobalSetting::query()->updateOrCreate(['key' => 'premium_' . $key], ['value' => $value]);
        }
        return back()->with('message', 'Premium Plan Setting Saved');

    }
}
