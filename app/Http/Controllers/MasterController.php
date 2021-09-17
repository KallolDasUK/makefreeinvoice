<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSendMail;
use App\Mail\PromoEmail;
use App\Models\Customer;
use App\Models\GlobalSetting;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

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

    public function hasValidSignature(Request $request, $absolute = true)
    {
        $url = $absolute ? $request->url() : '/' . $request->path();

        //dd($url);

        $original = rtrim($url . '?' . Arr::query(
                Arr::except($request->query(), 'signature')
            ), '?');

//        dd($original);
        $expires = Arr::get($request->query(), 'expires');

        $signature = hash_hmac('sha256', $original, call_user_func($this->keyResolver));

        return hash_equals($signature, (string)$request->query('signature', '')) &&
            !($expires && Carbon::now()->getTimestamp() > $expires);
    }

    public function loginClient(Request $request, $email)
    {

        if (Url::hasValidSignature($request) && $email != null) {
            $user = User::whereEmail($email)->firstOrFail();
            Auth::login($user);
            return redirect(route('acc.home'));
        } else
            abort(404);

    }

    public function sendEmailView(Request $request)
    {
        return view('master.send-email');
    }

    public function sendEmail(Request $request)
    {

        $emails = [];
        if ($request->has('client')) {
            $emails += User::query()->get()->pluck('email')->toArray();
        }
        if ($request->has('customer')) {
            $emails += Customer::withoutGlobalScope('scopeClient')
                ->pluck('email')->toArray();
        }
        if ($request->has('vendor')) {
            $emails += Vendor::withoutGlobalScope('scopeClient')
                ->pluck('email')->toArray();
        }

        foreach ($emails as $email) {
            $validator = validator()->make(['email' => $email], [
                'email' => 'email'
            ]);
            if ($validator->passes()) {
                Mail::to($email)->queue(new PromoEmail($request->all()));
            }
        }


        return back();
    }
}
