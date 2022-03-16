<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSendMail;
use App\Mail\PromoEmail;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\GlobalSetting;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\PosSale;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class MasterController extends Controller
{
    public function index()
    {
        return view('master.index');
    }

    public function user_settings_view(Request $request)
    {
//        dd($request->all());
        $selected_user = User::find($request->user_id);
//        dd($user);
        return view('partials.user-settings-form', compact('selected_user'));
    }

    public function user_settings(Request $request)
    {
        $params = $request->all();
        foreach ($params as $key => $value) {
            MetaSetting::query()
                ->withoutGlobalScope('scopeClient')
                ->updateOrCreate(['key' => $key, 'client_id' => $request->client_id], ['value' => $value, 'client_id' => $request->client_id]);


        }
        User::query()->where('client_id', $request->client_id)->update(['plan_type' => strtolower($request->plan_name)]);
//        dd($request->all());
        return back()->with('success_message', 'Settings was successfully updated.');
    }

    public function users(Request $request)
    {
        $filter_type = $request->filter_type;
        $sort_type = $request->sort_type;
        $plan_type = $request->plan_type;
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $email = $request->email;

        $users = DB::table('users')
            ->where('role_id', null)
            ->where('id', '!=', auth()->id())
            ->when($plan_type != null, function ($query) use ($plan_type) {
//                dd($plan_type);
                return $query->where('plan_type', $plan_type);
            })
            ->when($email != null, function ($query) use ($email) {
                return $query->where('email', $email);
            })
            ->when($filter_type != null && $email == null, function ($query) use ($filter_type, $start_date, $end_date) {
                if ($filter_type == "active_within") {
                    return $query->whereBetween('last_active_at', [$start_date, Carbon::parse($end_date)->addDay()->toDateString()]);
                } elseif ($filter_type == "joined_within") {
                    return $query->whereBetween('created_at', [$start_date, Carbon::parse($end_date)->addDay()->toDateString()]);
                }
                return $query;
            })
            ->when($sort_type != null && $email == null, function ($query) use ($sort_type, $filter_type) {

                if ($filter_type == "active_within") {
                    return $query->orderBy('last_active_at', $sort_type ?? 'desc');
                } elseif ($filter_type == "joined_within") {
                    return $query->orderBy('created_at', $sort_type ?? 'desc');
                }
                return $query;
            })
            ->when(count($request->all()) == 0, function ($query) {
                return $query->orderBy('last_active_at', 'desc');

            })
            ->paginate(10);

//        dd($users);
        $totalClients = \DB::table('users')->where('client_id', '!=', null)->count();
        $activeToday = \DB::table('users')
                ->where('client_id', '!=', null)
                ->whereDate('last_active_at', today()->toDateString())
                ->count();
        $activeYesterday = \DB::table('users')
            ->where('client_id', '!=', null)
            ->whereDate('last_active_at', today()->subDay()->toDateString())
            ->count();
        $joinedToday = \DB::table('users')
            ->where('client_id', '!=', null)
            ->whereDate('created_at', today()->toDateString())
            ->count();
        $joinedYesterday = \DB::table('users')
            ->where('client_id', '!=', null)
            ->whereDate('created_at', today()->subDay()->toDateString())
            ->count();
        return view('master.users', compact('users', 'totalClients', 'activeToday', 'joinedToday', 'joinedYesterday'
            , 'start_date', 'activeYesterday', 'end_date', 'filter_type', 'sort_type', 'email', 'plan_type'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $client_id = $user->client_id;
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {

            $table_name = $table->Tables_in_u100349385_invoicepedia;
            if ($table_name == 'users') {
                continue;
            }
            try {
                DB::table($table_name)->where('client_id', $client_id)->delete();
            } catch (\Exception $exception) {
                echo $exception->getMessage();
            }
        }
        $user->delete();
//        dd('sd');

        return back();

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
        if ($request->has('emails')) {
            $emails += explode(',', $request->a);
        }

//        dd($emails);
        foreach ($emails as $email) {
            $email = trim($email);
//            dump($email);
            $validator = validator()->make(['email' => $email], [
                'email' => 'email'
            ]);
            if ($validator->passes()) {
                Mail::to($email)->queue(new PromoEmail($request->all()));
            }
        }


        return back();
    }

    public function adSettings(Request $request)
    {
        dd($request->all());

    }

    public function adSettingsStore(Request $request)
    {
        dd($request->all());
    }


}
