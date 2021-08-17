<?php

namespace App\Providers;

use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\Estimate;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        view()->composer('*', function ($view) {
            if (optional(auth()->user())->client_id) {
                $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
                $view->with('settings', $settings);
            }

        });

        Estimate::created(function ($estimate) {
            $random = Str::random(40);
            $estimate->secret = $random;
        });

        Invoice::created(function ($invoice) {
            $random = Str::random(40);
            $invoice->secret = $random;
        });


        User::created(function ($user) {
            if ($user->client_id == null) {
                $user->client_id = $user->id;
            }
        });

        BillPaymentItem::created(function ($bill_payment) {
            $bill = $bill_payment->bill;
            $bill->payment_status = $bill->payment_status_text;
            $bill->save();
        });
        BillPaymentItem::deleted(function ($bill_payment) {
            $bill = $bill_payment->bill;
            $bill->payment_status = $bill->payment_status_text;
            $bill->save();
        });
        ReceivePaymentItem::created(function ($invoice_payment) {
            $invoice = $invoice_payment->invoice;
            $invoice->payment_status = $invoice->payment_status_text;
            $invoice->save();
        });
        ReceivePaymentItem::deleted(function ($invoice_payment) {
            $invoice = $invoice_payment->invoice;
            $invoice->payment_status = $invoice->payment_status_text;
            $invoice->save();
        });

    }
}

