<?php

use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\BillingsController;
use App\Http\Controllers\BillPaymentsController;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\BlogTagsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Estimates\EstimatesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\InventoryAdjustmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PosSalesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReasonsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\ReceivePaymentsController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\VendorsController;
use App\Models\BillItem;
use App\Models\Blog;
use App\Models\EstimateItem;
use App\Models\ExpenseItem;
use App\Models\InvoiceItem;
use App\Models\Reason;
use App\Models\Tax;
use Carbon\Carbon;
use Enam\Acc\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $posts = Blog::all();
    return view('landing.welcome', compact('posts'));
})->name('landing.index');

Auth::routes();
Route::get('/auth/redirect/{provider}', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/callback/{provider}', [SocialLoginController::class, 'callback'])->name('social.callback');

Route::group(['middleware' => 'auth:web', 'prefix' => 'app'], function () {


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    /*
     *  php artisan resource-file:create Customer --fields=id,name,photo,company_name,phone,email,address,website
     *  php artisan create:scaffold Customer  --layout-name="layouts.app" --with-migration
     * */
    Route::group(['prefix' => 'customers'], function () {

        Route::get('/', [CustomersController::class, 'index'])->name('customers.customer.index');
        Route::get('/create', [CustomersController::class, 'create'])->name('customers.customer.create');
        Route::get('/show/{customer}', [CustomersController::class, 'show'])->name('customers.customer.show')->where('id', '[0-9]+');
        Route::get('/{customer}/edit', [CustomersController::class, 'edit'])->name('customers.customer.edit')->where('id', '[0-9]+');
        Route::post('/', [CustomersController::class, 'store'])->name('customers.customer.store');
        Route::post('/storeJson', [CustomersController::class, 'storeJson'])->name('customers.customer.storeJson');
        Route::put('customer/{customer}', [CustomersController::class, 'update'])->name('customers.customer.update')->where('id', '[0-9]+');
        Route::delete('/customer/{customer}', [CustomersController::class, 'destroy'])->name('customers.customer.destroy')->where('id', '[0-9]+');

    });


    /*
     *  php artisan resource-file:create Vendor --fields=id,name,photo,company_name,phone,email,country,street_1,street_2,city,state,zip_post,address,website
     *  php artisan create:scaffold Vendor  --layout-name="acc::layouts.app" --with-migration
     * */

    Route::group(['prefix' => 'vendors'], function () {

        Route::get('/', [VendorsController::class, 'index'])->name('vendors.vendor.index');
        Route::get('/create', [VendorsController::class, 'create'])->name('vendors.vendor.create');
        Route::get('/show/{vendor}', [VendorsController::class, 'show'])->name('vendors.vendor.show')->where('id', '[0-9]+');
        Route::get('/{vendor}/edit', [VendorsController::class, 'edit'])->name('vendors.vendor.edit')->where('id', '[0-9]+');
        Route::post('/', [VendorsController::class, 'store'])->name('vendors.vendor.store');
        Route::put('vendor/{vendor}', [VendorsController::class, 'update'])->name('vendors.vendor.update')->where('id', '[0-9]+');
        Route::delete('/vendor/{vendor}', [VendorsController::class, 'destroy'])->name('vendors.vendor.destroy')->where('id', '[0-9]+');
    });


// php artisan resource-file:create Invoice --fields=id,customer_id,invoice_number,order_number,invoice_date,payment_terms,due_date,sub_total,total,discount_type,discount_value,discount,shipping_charge,terms_condition
// php artisan create:scaffold Invoice  --layout-name="layouts.app" --with-migration


    Route::group(['prefix' => 'invoices'], function () {

        Route::get('/', [InvoicesController::class, 'index'])->name('invoices.invoice.index');
        Route::get('/create', [InvoicesController::class, 'create'])->name('invoices.invoice.create');
        Route::get('/show/{invoice}', [InvoicesController::class, 'show'])->name('invoices.invoice.show')->where('id', '[0-9]+');
        Route::get('/share/{invoice}', [InvoicesController::class, 'share'])->name('invoices.invoice.share')->where('id', '[0-9]+')->withoutMiddleware('auth:web');
        Route::get('/send/{invoice}', [InvoicesController::class, 'send'])->name('invoices.invoice.send')->where('id', '[0-9]+');
        Route::get('/{invoice}/edit', [InvoicesController::class, 'edit'])->name('invoices.invoice.edit')->where('id', '[0-9]+');
        Route::post('/', [InvoicesController::class, 'store'])->name('invoices.invoice.store');
        Route::post('/send/{invoice}', [InvoicesController::class, 'sendInvoiceMail'])->name('invoices.invoice.send_invoice_mail');
        Route::put('invoice/{invoice}', [InvoicesController::class, 'update'])->name('invoices.invoice.update')->where('id', '[0-9]+');
        Route::delete('/invoice/{invoice}', [InvoicesController::class, 'destroy'])->name('invoices.invoice.destroy')->where('id', '[0-9]+');

    });


    Route::group(['prefix' => 'bills'], function () {

        Route::get('/', [BillsController::class, 'index'])->name('bills.bill.index');
        Route::get('/create', [BillsController::class, 'create'])->name('bills.bill.create');
        Route::get('/show/{bill}', [BillsController::class, 'show'])->name('bills.bill.show')->where('id', '[0-9]+');
        Route::get('/share/{bill}', [BillsController::class, 'share'])->name('bills.bill.share')->where('id', '[0-9]+')->withoutMiddleware('auth:web');
        Route::get('/send/{bill}', [BillsController::class, 'send'])->name('bills.bill.send')->where('id', '[0-9]+');
        Route::get('/{bill}/edit', [BillsController::class, 'edit'])->name('bills.bill.edit')->where('id', '[0-9]+');
        Route::post('/', [BillsController::class, 'store'])->name('bills.bill.store');
        Route::post('/send/{bill}', [BillsController::class, 'sendBillMail'])->name('bills.bill.send_bill_mail');
        Route::put('bill/{bill}', [BillsController::class, 'update'])->name('bills.bill.update')->where('id', '[0-9]+');
        Route::delete('/bill/{bill}', [BillsController::class, 'destroy'])->name('bills.bill.destroy')->where('id', '[0-9]+');

    });


    Route::group(['prefix' => 'estimates'], function () {

        Route::get('/', [EstimatesController::class, 'index'])->name('estimates.estimate.index');
        Route::get('/create', [EstimatesController::class, 'create'])->name('estimates.estimate.create');
        Route::get('/show/{estimate}', [EstimatesController::class, 'show'])->name('estimates.estimate.show')->where('id', '[0-9]+');
        Route::get('/share/{estimate}', [EstimatesController::class, 'share'])->name('estimates.estimate.share')->where('id', '[0-9]+')->withoutMiddleware('auth:web');
        Route::get('/send/{estimate}', [EstimatesController::class, 'send'])->name('estimates.estimate.send')->where('id', '[0-9]+');
        Route::get('/{estimate}/edit', [EstimatesController::class, 'edit'])->name('estimates.estimate.edit')->where('id', '[0-9]+');
        Route::post('/', [EstimatesController::class, 'store'])->name('estimates.estimate.store');
        Route::post('/send/{estimate}', [EstimatesController::class, 'sendestimateMail'])->name('estimates.estimate.send_estimate_mail');
        Route::get('/convert-to-invoice/{estimate}', [EstimatesController::class, 'convertToInvoice'])->name('estimates.estimate.convert_to_invoice');
        Route::put('estimate/{estimate}', [EstimatesController::class, 'update'])->name('estimates.estimate.update')->where('id', '[0-9]+');
        Route::delete('/estimate/{estimate}', [EstimatesController::class, 'destroy'])->name('estimates.estimate.destroy')->where('id', '[0-9]+');

    });


// php artisan resource-file:create Category --fields=id,name,category_id
// php artisan create:scaffold Category  --layout-name="layouts.app" --with-migration


    Route::group(['prefix' => 'categories'], function () {

        Route::get('/', [CategoriesController::class, 'index'])->name('categories.category.index');
        Route::get('/create', [CategoriesController::class, 'create'])->name('categories.category.create');
        Route::get('/show/{category}', [CategoriesController::class, 'show'])->name('categories.category.show')->where('id', '[0-9]+');
        Route::get('/{category}/edit', [CategoriesController::class, 'edit'])->name('categories.category.edit')->where('id', '[0-9]+');
        Route::post('/', [CategoriesController::class, 'store'])->name('categories.category.store');
        Route::put('category/{category}', [CategoriesController::class, 'update'])->name('categories.category.update')->where('id', '[0-9]+');
        Route::delete('/category/{category}', [CategoriesController::class, 'destroy'])->name('categories.category.destroy')->where('id', '[0-9]+');

    });
// php artisan resource-file:create Product --fields=id,product_type,name,photo,category_id,sell_price,sell_unit,purchase_price,purchase_unit,description,is_track,opening_stock,opening_stock_price
// php artisan create:scaffold Product  --layout-name="layouts.app" --with-migration

    Route::group(['prefix' => 'products'], function () {

        Route::get('/', [ProductsController::class, 'index'])->name('products.product.index');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.product.create');
        Route::get('/show/{product}', [ProductsController::class, 'show'])->name('products.product.show')->where('id', '[0-9]+');
        Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('products.product.edit')->where('id', '[0-9]+');
        Route::post('/', [ProductsController::class, 'store'])->name('products.product.store');
        Route::put('product/{product}', [ProductsController::class, 'update'])->name('products.product.update')->where('id', '[0-9]+');
        Route::delete('/product/{product}', [ProductsController::class, 'destroy'])->name('products.product.destroy')->where('id', '[0-9]+');

    });
// php artisan resource-file:create Tax --fields=id,name,value,tax_type
// php artisan create:scaffold Tax  --layout-name="acc::layouts.app" --with-migration

    Route::group(['prefix' => 'taxes'], function () {

        Route::get('/', [TaxesController::class, 'index'])->name('taxes.tax.index');
        Route::get('/create', [TaxesController::class, 'create'])->name('taxes.tax.create');
        Route::get('/show/{tax}', [TaxesController::class, 'show'])->name('taxes.tax.show')->where('id', '[0-9]+');
        Route::get('/{tax}/edit', [TaxesController::class, 'edit'])->name('taxes.tax.edit')->where('id', '[0-9]+');
        Route::post('/', [TaxesController::class, 'store'])->name('taxes.tax.store');
        Route::put('tax/{tax}', [TaxesController::class, 'update'])->name('taxes.tax.update')->where('id', '[0-9]+');
        Route::delete('/tax/{tax}', [TaxesController::class, 'destroy'])->name('taxes.tax.destroy')->where('id', '[0-9]+');

    });


// php artisan resource-file:create ReceivePayment --fields=id,customer_id,invoice,payment_date,payment_sl,payment_method_id,deposit_to,note
// php artisan resource-file:create ReceivePaymentItem --fields=id,receive_payment_id,invoice_id,payment
// php artisan create:scaffold ReceivePayment  --layout-name="acc::layouts.app" --with-migration


    Route::group(['prefix' => 'receive_payments'], function () {

        Route::get('/', [ReceivePaymentsController::class, 'index'])->name('receive_payments.receive_payment.index');
        Route::get('/create', [ReceivePaymentsController::class, 'create'])->name('receive_payments.receive_payment.create');
        Route::get('/show/{receivePayment}', [ReceivePaymentsController::class, 'show'])->name('receive_payments.receive_payment.show')->where('id', '[0-9]+');
        Route::get('/{receivePayment}/edit', [ReceivePaymentsController::class, 'edit'])->name('receive_payments.receive_payment.edit')->where('id', '[0-9]+');
        Route::post('/', [ReceivePaymentsController::class, 'store'])->name('receive_payments.receive_payment.store');
        Route::put('receive_payment/{receivePayment}', [ReceivePaymentsController::class, 'update'])->name('receive_payments.receive_payment.update')->where('id', '[0-9]+');
        Route::delete('/receive_payment/{receivePayment}', [ReceivePaymentsController::class, 'destroy'])->name('receive_payments.receive_payment.destroy')->where('id', '[0-9]+');

    });


    Route::group(['prefix' => 'bill_payments'], function () {

        Route::get('/', [BillPaymentsController::class, 'index'])->name('bill_payments.bill_payment.index');
        Route::get('/create', [BillPaymentsController::class, 'create'])->name('bill_payments.bill_payment.create');
        Route::get('/show/{billPayment}', [BillPaymentsController::class, 'show'])->name('bill_payments.bill_payment.show');
        Route::get('/{billPayment}/edit', [BillPaymentsController::class, 'edit'])->name('bill_payments.bill_payment.edit');
        Route::post('/', [BillPaymentsController::class, 'store'])->name('bill_payments.bill_payment.store');
        Route::put('bill_payment/{billPayment}', [BillPaymentsController::class, 'update'])->name('bill_payments.bill_payment.update');
        Route::delete('/bill_payment/{billPayment}', [BillPaymentsController::class, 'destroy'])->name('bill_payments.bill_payment.destroy');

    });


    Route::group(['prefix' => 'payment_methods'], function () {

        Route::get('/', [PaymentMethodsController::class, 'index'])->name('payment_methods.payment_method.index');
        Route::get('/create', [PaymentMethodsController::class, 'create'])->name('payment_methods.payment_method.create');
        Route::get('/show/{paymentMethod}', [PaymentMethodsController::class, 'show'])->name('payment_methods.payment_method.show');
        Route::get('/{paymentMethod}/edit', [PaymentMethodsController::class, 'edit'])->name('payment_methods.payment_method.edit');
        Route::post('/', [PaymentMethodsController::class, 'store'])->name('payment_methods.payment_method.store');
        Route::put('payment_method/{paymentMethod}', [PaymentMethodsController::class, 'update'])->name('payment_methods.payment_method.update');
        Route::delete('/payment_method/{paymentMethod}', [PaymentMethodsController::class, 'destroy'])->name('payment_methods.payment_method.destroy');

    });

    /*
     * AJAX Form Requests Handler
     * */
    Route::group(['prefix' => 'ajax'], function () {
        Route::post('/invoice-payment-customers-invoice', [AjaxController::class, 'receivePaymentCustomerInvoice'])->name('receive-payment-customers-invoice');
        Route::post('/vendor-unpaid-bill-list', [AjaxController::class, 'vendorUnpaidBill'])->name('vendor_unpaid_bills');
        Route::post('/invoice-payment-transactions/{invoice}', [AjaxController::class, 'invoicePaymentTransactions'])->name('invoices.invoice.payments');
        Route::post('/invoice-payment', [AjaxController::class, 'invoicePayment'])->name('ajax.recordPayment');
        Route::post('/bill-payment', [AjaxController::class, 'billPayment'])->name('ajax.billPayment');
    });


    /*
    *  php artisan resource-file:create Expense --fields=id,date,ledger_id,vendor_id,customer_id,ref,is_billable,files
    *  php artisan create:scaffold Expense  --layout-name="acc::layouts.app" --with-migration
    * */

    Route::group(['prefix' => 'expenses'], function () {

        Route::get('/', [ExpensesController::class, 'index'])->name('expenses.expense.index');
        Route::get('/create', [ExpensesController::class, 'create'])->name('expenses.expense.create');
        Route::get('/show/{expense}', [ExpensesController::class, 'show'])->name('expenses.expense.show')->where('id', '[0-9]+');
        Route::get('/{expense}/edit', [ExpensesController::class, 'edit'])->name('expenses.expense.edit')->where('id', '[0-9]+');
        Route::post('/', [ExpensesController::class, 'store'])->name('expenses.expense.store');
        Route::put('expense/{expense}', [ExpensesController::class, 'update'])->name('expenses.expense.update')->where('id', '[0-9]+');
        Route::delete('/expense/{expense}', [ExpensesController::class, 'destroy'])->name('expenses.expense.destroy')->where('id', '[0-9]+');

    });

    Route::group(['prefix' => 'subscriptions'], function () {


        Route::get('/', [BillingsController::class, 'index'])->name('subscriptions.settings');
        Route::get('/update-password', [SettingsController::class, 'updatePasswordView'])->name('settings.update_password');
        Route::post('/update-password', [SettingsController::class, 'storePassword'])->name('settings.update_password.store');
        Route::get('/modal', [BillingsController::class, 'subscriptionModal'])->name('subscriptions.modal');
        Route::post('/subscribe', [BillingsController::class, 'purchaseSubscription'])->name('subscribe.store');
        Route::post('/cancel', [BillingsController::class, 'cancelSubscription'])->name('subscriptions.cancel');
        Route::get('/invoice/{invoice}', [BillingsController::class, 'downloadInvoice'])->name('subscriptions.download-invoice');


    });

    Route::group(['prefix' => 'reports'], function () {

        Route::get('/', [ReportController::class, 'index'])->name('reports.report.index');
        Route::get('/tax-report', [ReportController::class, 'taxReport'])->name('reports.report.tax_report');
        Route::get('/ar-aging-report', [ReportController::class, 'arAgingReport'])->name('reports.report.ar_aging_report');
        Route::get('/ap-aging-report', [ReportController::class, 'apAgingReport'])->name('reports.report.ap_aging_report');
        Route::get('/stock-report', [ReportController::class, 'stockReport'])->name('reports.report.stock-report');
        Route::get('/trial-balance', [ReportController::class, 'trialBalance'])->name('reports.report.trial_balance');
        Route::get('/ledger-report', [ReportController::class, 'ledgerReport'])->name('reports.report.ledger_report');
        Route::get('/loss-profit', [ReportController::class, 'lossProfitReport'])->name('reports.report.loss_profit_report');
        Route::get('/cash-book', [ReportController::class, 'cashbookReport'])->name('reports.report.cashbook');
        Route::get('/balance-sheet', [ReportController::class, 'balanceSheetReport'])->name('reports.report.balance_sheet_report');
        Route::get('/receipt-payment', [ReportController::class, 'receiptPaymentReport'])->name('reports.report.receipt_payment_report');
        Route::get('/voucher-report', [ReportController::class, 'voucherReport'])->name('reports.report.voucher_report');
        Route::get('/customer-statement', [ReportController::class, 'customerStatement'])->name('reports.report.customer_statement');
        Route::get('/vendor-statement', [ReportController::class, 'vendorStatement'])->name('reports.report.vendor_statement');
        Route::get('/sales-report', [ReportController::class, 'salesReport'])->name('reports.report.sales_report');
        Route::get('/purchase-report', [ReportController::class, 'purchaseReport'])->name('reports.report.purchase_report');
// Test Comment
    });


    /*
        *  php artisan resource-file:create InventoryAdjustment --fields=id,date,ref,ledger_id,reason_id,description
        *  php artisan create:scaffold InventoryAdjustment  --layout-name="acc::layouts.app" --with-migration
        *  php artisan resource-file:create PosSale --fields=id,pos_number,date,customer_id,branch_id,ledger_id,discount_type,discount,vat,service_charge_type,service_charge,note,payment_method,sub_total,total,payment_amount,due,pos_status
        *  php artisan create:scaffold PosSale  --layout-name="acc::layouts.app" --with-migration
     * */

    Route::group(['prefix' => 'inventory_adjustments'], function () {

        Route::get('/', [InventoryAdjustmentsController::class, 'index'])->name('inventory_adjustments.inventory_adjustment.index');
        Route::get('/create', [InventoryAdjustmentsController::class, 'create'])->name('inventory_adjustments.inventory_adjustment.create');
        Route::get('/show/{inventoryAdjustment}', [InventoryAdjustmentsController::class, 'show'])->name('inventory_adjustments.inventory_adjustment.show')->where('id', '[0-9]+');
        Route::get('/{inventoryAdjustment}/edit', [InventoryAdjustmentsController::class, 'edit'])->name('inventory_adjustments.inventory_adjustment.edit')->where('id', '[0-9]+');
        Route::post('/', [InventoryAdjustmentsController::class, 'store'])->name('inventory_adjustments.inventory_adjustment.store');
        Route::put('inventory_adjustment/{inventoryAdjustment}', [InventoryAdjustmentsController::class, 'update'])->name('inventory_adjustments.inventory_adjustment.update')->where('id', '[0-9]+');
        Route::delete('/inventory_adjustment/{inventoryAdjustment}', [InventoryAdjustmentsController::class, 'destroy'])->name('inventory_adjustments.inventory_adjustment.destroy')->where('id', '[0-9]+');

    });

// php artisan create:scaffold Reason  --layout-name="acc::layouts.app" --with-migration

    Route::group(['prefix' => 'reasons'], function () {

        Route::get('/', [ReasonsController::class, 'index'])->name('reasons.reason.index');
        Route::get('/create', [ReasonsController::class, 'create'])->name('reasons.reason.create');
        Route::get('/show/{reason}', [ReasonsController::class, 'show'])->name('reasons.reason.show');
        Route::get('/{reason}/edit', [ReasonsController::class, 'edit'])->name('reasons.reason.edit');
        Route::post('/', [ReasonsController::class, 'store'])->name('reasons.reason.store');
        Route::put('reason/{reason}', [ReasonsController::class, 'update'])->name('reasons.reason.update');
        Route::delete('/reason/{reason}', [ReasonsController::class, 'destroy'])->name('reasons.reason.destroy');

    });

    /*
        *  php artisan resource-file:create PosSale --fields=id,pos_number,date,customer_id,branch_id,ledger_id,discount_type,discount,vat,service_charge_type,service_charge,note,payment_method,sub_total,total,payment_amount,due,pos_status
        *  php artisan create:scaffold PosSale  --layout-name="acc::layouts.app" --with-migration
     * */
    Route::group(['prefix' => 'pos_sales'], function () {

        Route::get('/', [PosSalesController::class,'index'])->name('pos_sales.pos_sale.index');
        Route::get('/create',[PosSalesController::class,'create'])->name('pos_sales.pos_sale.create');
        Route::get('/show/{posSale}',[PosSalesController::class,'show'])->name('pos_sales.pos_sale.show')->where('id', '[0-9]+');
        Route::get('/details',[PosSalesController::class,'details'])->name('pos_sales.pos_sale.details')->where('id', '[0-9]+');
        Route::get('/{posSale}/edit',[PosSalesController::class,'edit'])->name('pos_sales.pos_sale.edit')->where('id', '[0-9]+');
        Route::post('/', [PosSalesController::class,'store'])->name('pos_sales.pos_sale.store');
        Route::put('pos_sale/{posSale}', [PosSalesController::class,'update'])->name('pos_sales.pos_sale.update')->where('id', '[0-9]+');
        Route::delete('/pos_sale/{posSale}',[PosSalesController::class,'destroy'])->name('pos_sales.pos_sale.destroy')->where('id', '[0-9]+');

    });
});


/*
 *  php artisan resource-file:create Blog --fields=id,title,slug,body,user_id,client_id
 *  php artisan create:scaffold Blog  --layout-name="layouts.app" --with-migration
 *
 * */
Route::get('p/{slug}', [BlogsController::class, 'show'])->name('blogs.blog.show')->where('id', '[0-9]+');





Route::get('/task', function () {

//    Artisan::call('db:seed --class=AccountingSeeder');

//    Reason::create(['name' => 'Reason 1']);
//    Reason::create(['name' => 'Reason 2']);
    $user = auth()->user();
    if (auth()->user()->subscribed('default')) {
        $user->subscription('default')->cancelNow();
    }
    dd('task completed', auth()->user()->subscribed('default'), auth()->user()->invoices());
});


Route::group(['prefix' => 'master', 'middleware' => ['auth:web', 'isMaster']], function () {
    Route::get('/', [MasterController::class, 'index'])->name('master.index');
    Route::get('/subscriptions', [MasterController::class, 'subscriptions'])->name('master.subscriptions');
    Route::post('/subscriptions/free-plan', [MasterController::class, 'freePlanSettings'])->name('master.subscriptions.free_plan');
    Route::post('/subscriptions/basic-plan', [MasterController::class, 'basicPlanSettings'])->name('master.subscriptions.basic_plan');
    Route::post('/subscriptions/premium-plan', [MasterController::class, 'premiumPlanSettings'])->name('master.subscriptions.premium_plan');
    Route::get('/users', [MasterController::class, 'users'])->name('master.users');

    Route::group(['prefix' => 'blogs'], function () {


        Route::get('/', [BlogsController::class, 'index'])->name('blogs.blog.index');
        Route::get('/create', [BlogsController::class, 'create'])->name('blogs.blog.create');
        Route::get('/{blog}/edit', [BlogsController::class, 'edit'])->name('blogs.blog.edit')->where('id', '[0-9]+');
        Route::post('/', [BlogsController::class, 'store'])->name('blogs.blog.store');
        Route::put('blog/{blog}', [BlogsController::class, 'update'])->name('blogs.blog.update')->where('id', '[0-9]+');
        Route::delete('/blog/{blog}', [BlogsController::class, 'destroy'])->name('blogs.blog.destroy')->where('id', '[0-9]+');

    });

    Route::group([
        'prefix' => 'blog_tags',
    ], function () {

        Route::get('/', [BlogTagsController::class, 'index'])->name('blog_tags.blog_tag.index');
        Route::get('/create', [BlogTagsController::class, 'create'])->name('blog_tags.blog_tag.create');
        Route::get('/show/{blogTag}', [BlogTagsController::class, 'show'])->name('blog_tags.blog_tag.show');
        Route::get('/{blogTag}/edit', [BlogTagsController::class, 'edit'])->name('blog_tags.blog_tag.edit');
        Route::post('/', [BlogTagsController::class, 'store'])->name('blog_tags.blog_tag.store');
        Route::put('blog_tag/{blogTag}', [BlogTagsController::class, 'update'])->name('blog_tags.blog_tag.update');
        Route::delete('/blog_tag/{blogTag}', [BlogTagsController::class, 'destroy'])->name('blog_tags.blog_tag.destroy');

    });


    Route::get('/send_email', [MasterController::class, 'sendEmailView'])->name('master.send_email');
    Route::post('/send_email', [MasterController::class, 'sendEmail'])->name('master.send_email_store');
});
Route::get('master/users/login/{email}', [MasterController::class, 'loginClient'])->name('master.users.login');




