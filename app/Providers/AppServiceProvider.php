<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\ExpenseItem;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\User;
use App\Observers\BillObserver;
use App\Observers\BillPaymentItemObserver;
use App\Observers\ExpenseItemObserver;
use App\Observers\InvoiceObserver;
use App\Observers\PosPaymentObserver;
use App\Observers\PosSaleObserver;
use App\Observers\ReceivePaymentItemObserver;
use App\Policies\ReportPolicy;
use App\Rules\UniqueCode;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Http\Controllers\TransactionsController;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

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


    public function boot()
    {

        Validator::extend('unique_saas', function ($attribute, $value, $parameters) {
            $table = $parameters[0] ?? null;
            $field_name = $parameters[1] ?? null;
            $index = $parameters[2] ?? null;
            if ($index) {
                $exits = DB::table($table)
                    ->where('client_id', auth()->user()->client_id)
                    ->where('id', '!=', $index)
                    ->where($field_name, $value)->exists();
            } else {
                $exits = DB::table($table)
                    ->where('client_id', auth()->user()->client_id)
                    ->where($field_name, $value)->exists();
            }
            return !$exits;
        });
        Validator::extend('except_sisir', function ($attribute, $value, $parameters) {
                return $value != 'sisir';
        });


        $country = ip_info(\request()->ip(), "Country");

        Paginator::useBootstrap();
        view()->composer('*', function ($view) use ($country) {
            $is_desktop = true;
            if (optional(auth()->user())->client_id) {
                $settings = json_decode(MetaSetting::query()->pluck('value', 'key')->toJson());
//                dd(settings());
                $agent = new Agent();
                $is_desktop = $agent->isDesktop();
//                dd($is_desktop);
                $view->with('settings', $settings);
            }

//            dd(auth()->user()->user_unseen_notifications);
            $view->with('is_desktop', $is_desktop);
            $view->with('country', $country);
            $view->with('user', auth()->user());

        });


        Invoice::observe(InvoiceObserver::class);
        Bill::observe(BillObserver::class);
        PosSale::observe(PosSaleObserver::class);
        PosPayment::observe(PosPaymentObserver::class);
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


        Gate::define('tax_summary', [ReportPolicy::class, 'tax_summary']);
        Gate::define('ar_aging', [ReportPolicy::class, 'ar_aging']);
        Gate::define('ap_aging', [ReportPolicy::class, 'ap_aging']);
        Gate::define('stock_report', [ReportPolicy::class, 'stock_report']);
        Gate::define('trial_balance', [ReportPolicy::class, 'trial_balance']);
        Gate::define('receipt_payment', [ReportPolicy::class, 'receipt_payment']);
        Gate::define('ledger', [ReportPolicy::class, 'ledger']);
        Gate::define('profit_loss', [ReportPolicy::class, 'profit_loss']);
        Gate::define('voucher', [ReportPolicy::class, 'voucher']);
        Gate::define('cash_book', [ReportPolicy::class, 'cash_book']);
        Gate::define('day_book', [ReportPolicy::class, 'day_book']);
        Gate::define('balance_sheet', [ReportPolicy::class, 'balance_sheet']);
    }
}

