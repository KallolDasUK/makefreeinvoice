<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\Estimate;
use App\Models\ExpenseItem;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\User;
use App\Observers\BillObserver;
use App\Observers\BillPaymentItemObserver;
use App\Observers\ExpenseItemObserver;
use App\Observers\InvoiceObserver;
use App\Observers\ReceivePaymentItemObserver;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Http\Controllers\TransactionsController;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
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
//                dd(settings());
                $view->with('settings', $settings);
            }

        });
//        $txn = TransactionDetail::query()
//            ->where('type', '!=', Ledger::class)
//            ->where('ledger_id', 3)->get();
//        dd($txn);
//        dd(TransactionDetail::query()->get()->toArray());
//        dd(Ledger::find(3)->transaction_details);

        Invoice::observe(InvoiceObserver::class);
        Bill::observe(BillObserver::class);
        ExpenseItem::observe(ExpenseItemObserver::class);
        ReceivePaymentItem::observe(ReceivePaymentItemObserver::class);
        BillPaymentItem::observe(BillPaymentItemObserver::class);

        Estimate::created(function ($estimate) {
            $random = Str::random(40);
            $estimate->secret = $random;
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


    }
}

