<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSendMail;
use App\Mail\PromoEmail;
use App\Models\Bill;
use App\Models\Customer;
use App\Models\GlobalSetting;
use App\Models\Invoice;
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

    public function users()
    {

        $users = User::withCount(['invoices', 'pos_sales'])
            ->orderBy('invoices_count', 'desc')
            ->orderBy('created_at', 'asc')
            ->paginate(25);

//        dd($users);
        $totalClients = 0;
        $totalInvoices = 0;
        $totalBills = 0;
        $totalClients += count(User::all());
        foreach (User::all() as $user) {
            $totalInvoices += count($user->invoices);
            $totalBills += count($user->bills);
        }
        $totalPosSale = count(\DB::table('pos_sales')->where('client_id', '!=', null)->get());
        return view('master.users', compact('users', 'totalBills', 'totalClients', 'totalInvoices', 'totalPosSale'));
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $client_id = $user->client_id;
        $tables = DB::select('SHOW TABLES');
        foreach ($tables as $table) {
            $table_name = $table->Tables_in_kinetixb_accounting;
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
}
