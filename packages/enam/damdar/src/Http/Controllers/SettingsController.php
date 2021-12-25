<?php

namespace Enam\Acc\Http\Controllers;

use App\Models\CollectPayment;
use App\Models\MetaSetting;
use App\Models\PaymentRequest;
use App\Models\User;
use Carbon\Carbon;
use Enam\Acc\Http\Controllers\Controller;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Setting;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\View;

class SettingsController extends Controller
{
    use TransactionTrait;


    public function edit()
    {
        View::share('title', 'Settings');

//        dd(Carbon::today());
        return view('acc::settings.settings');
    }

    public function posSettings()
    {
        View::share('title', 'POS Settings');
        return view('settings.pos-settings');
    }

    public function personalizationSettings()
    {
        View::share('title', 'Personalization Settings');
        return view('settings.personalization-settings');
    }

    public function update(Request $request)
    {

        $params = $request->all();
        if ($request->hasFile('business_logo')) {
            $params['business_logo'] = $this->moveFile($request->file('business_logo'));
        }

        foreach ($params as $key => $value) {
            MetaSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return back()->with('success_message', 'Settings was successfully updated.');

    }

    public function posSettingsStore(Request $request)
    {

        $params = $request->all();

        foreach ($params as $key => $value) {
            MetaSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return back()->with('success_message', 'POS Settings was successfully updated.');

    }

    public function personalizationSettingsStore(Request $request)
    {

        $params = $request->all();

        foreach ($params as $key => $value) {
            MetaSetting::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        return back()->with('success_message', 'POS Settings was successfully updated.');

    }

    protected function moveFile($file)
    {
        if (!$file->isValid()) {
            return '';
        }

        $path = config('laravel-code-generator.files_upload_path', 'uploads');
        $saved = $file->store('public/' . $path, config('filesystems.default'));

        return substr($saved, 7);
    }

    public function updatePasswordView()
    {
        return view('settings.update-password');

    }

    public function referEarn()
    {
        $user = auth()->user();
        $affiliatedUsers = $user->referred;
        $totalReferredUser = count($affiliatedUsers ?? []);


        $collectPayments = CollectPayment::query()->where('referred_by', $user->id)->sum('referred_by_amount');
        $totalEarnings = $collectPayments;
        $totalWithdraw = PaymentRequest::query()->where('user_id', $user->id)
            ->where('status', '!=', 'Rejected')->sum('amount');
        $histories = PaymentRequest::query()->where('user_id', $user->id)->latest()->get();

        $balance = $collectPayments - $totalWithdraw;
        return view('settings.refer-earn', compact('user',
            'affiliatedUsers', 'totalReferredUser', 'totalEarnings',
            'balance', 'totalWithdraw', 'histories'));

    }

    public function storePassword(Request $request)
    {

        $data = $request->validate([
            'new_password' => 'required',
            'confirmed_password' => 'required|same:new_password',
        ]);

        auth()->user()->update(['password' => \Hash::make($data['new_password'])]);
        session()->flash('success_message', 'Password changed successfully.');

        return back();
    }

}
