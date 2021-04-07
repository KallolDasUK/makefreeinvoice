<?php

namespace Enam\Acc\Http\Controllers;

use App\Models\User;
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


    /**
     * Show the form for editing the specified ledger.
     *
     * @param int $id
     *
     * @return Illuminate\View\View
     */
    public function edit()
    {
        View::share('title', 'Settings');

        return view('acc::settings.settings');
    }

    /**
     * Update the specified ledger in the storage.
     *
     * @param int $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\RedirectResponse | Illuminate\Routing\Redirector
     */
    public function update( Request $request)
    {

        $settings = Setting::query()->first();
        $settings->name = $request->name;
        $settings->email = $request->email;
        $settings->address = $request->address;
        $settings->phone = $request->phone;
        $settings->save();

        return back()
            ->with('success_message', 'Settings was successfully updated.');

    }


}
