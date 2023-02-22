<?php

namespace App\Providers;

use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\BillPaymentItem;
use App\Models\ContactInvoice;
use App\Models\CollectPayment;
use App\Models\ContactInvoicePaymentItem;
use App\Models\Customer;
use App\Models\Estimate;
use App\Models\ExpenseItem;
use App\Models\Invoice;
use App\Models\MetaSetting;
use App\Models\PaymentMethod;
use App\Models\PosItem;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\ReceivePayment;
use App\Models\ReceivePaymentItem;
use App\Models\User;
use App\Observers\BillObserver;
use App\Observers\BillPaymentItemObserver;
use App\Observers\ContactInvoiceObserver;
use App\Observers\ContactInvoicePaymentItemObserver;
use App\Observers\ExpenseItemObserver;
use App\Observers\InvoiceObserver;
use App\Observers\PosPaymentObserver;
use App\Observers\PosSaleItemObserver;
use App\Observers\PosSaleObserver;
use App\Observers\ReceivePaymentItemObserver;
use App\Policies\BasePolicy;
use App\Policies\CustomerPolicy;
use App\Policies\ProductPolicy;
use App\Policies\ReportPolicy;
use App\Policies\VendorPolicy;
use App\Rules\UniqueCode;
use Enam\Acc\AccountingFacade;
use Enam\Acc\Http\Controllers\TransactionsController;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use GPBMetadata\Google\Api\Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
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

    }


    public function boot()
    {
//        Blade::setEchoFormat('e(utf8_encode(%s))');
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
                $payment_history = session('payment_history');
                $settings = BasePolicy::getSettings();
                if (!$payment_history) {
                    $payment_history = CollectPayment::query()->where('user_id', auth()->user()->id)->latest('date')->get();
                    session()->put('payment_history', $payment_history);
                }


                $remainingDay = 0;

                if (count($payment_history)) {
                    $today = today();
                    $paymentDate = \Carbon\Carbon::parse($payment_history[0]->date);

                    $futurePayDate = $paymentDate->addDays(365);
                    $remainingDay = $futurePayDate->diffInDays($today);

                }


                $agent = new Agent();
                $is_desktop = $agent->isDesktop();

                if ($settings->timezone ?? false) {
                    config(['app.timezone' => $settings->timezone]);
                    date_default_timezone_set($settings->timezone);
                }
                $view->with('settings', $settings);
                $view->with('remainingDay', $remainingDay);
            }


            $view->with('is_desktop', $is_desktop);
            $view->with('country', $country);
            $view->with('user', auth()->user());

        });


        Invoice::observe(InvoiceObserver::class);

        Bill::observe(BillObserver::class);
        ContactInvoice::observe(ContactInvoiceObserver::class);

        PosSale::observe(PosSaleObserver::class);
        PosItem::observe(PosSaleItemObserver::class);
        PosPayment::observe(PosPaymentObserver::class);

        ExpenseItem::observe(ExpenseItemObserver::class);
        ReceivePaymentItem::observe(ReceivePaymentItemObserver::class);

        BillPaymentItem::observe(BillPaymentItemObserver::class);
        ContactInvoicePaymentItem::observe(ContactInvoicePaymentItemObserver::class);

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
        Gate::define('product_report', [ReportPolicy::class, 'product_report']);
        Gate::define('customer_report', [ReportPolicy::class, 'customer_report']);
        Gate::define('vendor_report', [ReportPolicy::class, 'vendor_report']);
        Gate::define('customer_statement', [ReportPolicy::class, 'customer_statement']);
        Gate::define('vendor_statement', [ReportPolicy::class, 'vendor_statement']);
        Gate::define('sales_report', [ReportPolicy::class, 'sales_report']);
        Gate::define('sales_report_details', [ReportPolicy::class, 'sales_report_details']);
        Gate::define('purchase_report', [ReportPolicy::class, 'purchase_report']);
        Gate::define('purchase_report_details', [ReportPolicy::class, 'purchase_report_details']);
        Gate::define('due_collection', [ReportPolicy::class, 'due_collection']);
        Gate::define('due_payment', [ReportPolicy::class, 'due_payment']);


        Gate::define('print_barcode', [ProductPolicy::class, 'print_barcode']);
        Gate::define('receive_payment', [CustomerPolicy::class, 'receive_payment']);
        Gate::define('bill_payment', [VendorPolicy::class, 'bill_payment']);
    }
}

