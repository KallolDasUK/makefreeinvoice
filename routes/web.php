<?php

use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\BillingsController;
use App\Http\Controllers\BillPaymentsController;
use App\Http\Controllers\BillsController;
use App\Http\Controllers\BlogCategoriesController;
use App\Http\Controllers\CollectPaymentsController;
use App\Http\Controllers\ContactInvoiceController;
use App\Http\Controllers\CustomerAdvancePaymentsController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentRequestsController;
use App\Http\Controllers\ProductionsController;
use App\Http\Controllers\PurchaseOrdersController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\BlogTagsController;
use App\Http\Controllers\BrandsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Estimates\EstimatesController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\InventoryAdjustmentsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PosSalesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PurchaseReturnsController;
use App\Http\Controllers\ReasonsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SalesReturnsController;
use App\Http\Controllers\ShortcutsController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\SRsController;
use App\Http\Controllers\StockEntriesController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\ReceivePaymentsController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\UserNotificationsController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\VendorAdvancePaymentsController;
use App\Http\Controllers\VendorsController;
use App\Http\Controllers\FrontendController;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\BillPaymentItem;
use App\Models\Blog;
use App\Models\Customer;
use App\Models\EstimateItem;
use App\Models\Expense;
use App\Models\ExpenseItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\MetaSetting;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\ProductUnit;
use App\Models\Reason;
use App\Models\ReceivePaymentItem;
use App\Models\Tax;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Enam\Acc\Http\Controllers\SettingsController;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BannerAdsController;


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
//Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
//    \UniSharp\LaravelFilemanager\Lfm::routes();
//});


Route::get('/', function (Request $request) {


    $posts = Blog::all();
    if (auth()->user()) {
        return redirect()->route('acc.home');
    }
    return view('landing.welcome', compact('posts'));
})->name('landing.index');

Route::get('/articles',[FrontendController::class,'article_page']);
Route::get('/article/{slug}',[FrontendController::class,'article_details'])->name('article_details');



Auth::routes();
Route::get('/auth/redirect/{provider}', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/callback/{provider}', [SocialLoginController::class, 'callback'])->name('social.callback');

Route::group(['middleware' => 'auth:web', 'prefix' => 'app'], function () {


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');







    Route::group(['prefix' => 'accounting/settings'], function () {
        Route::get('/', [SettingsController::class, 'edit'])->name('accounting.settings.edit');
        Route::get('/pos', [SettingsController::class, 'posSettings'])->name('accounting.settings.pos_settings');
        Route::post('/pos', [SettingsController::class, 'posSettingsStore'])->name('accounting.settings.pos_settings_store');
        Route::get('/personalization', [SettingsController::class, 'personalizationSettings'])->name('accounting.settings.personalization_settings');
        Route::post('/personalization', [SettingsController::class, 'personalizationSettingsStore'])->name('accounting.settings.personalization_settings_store');
        Route::post('/store', [SettingsController::class, 'update'])->name('accounting.settings.update');
    });

    /*
     *  php artisan resource-file:create Customer --fields=id,name,photo,company_name,phone,email,address,website
     *  php artisan create:scaffold Customer  --layout-name="layouts.app" --with-migration
     * */
    Route::group(['prefix' => 'customers'], function () {

        Route::get('/', [CustomersController::class, 'index'])->name('customers.customer.index');
        Route::get('/create', [CustomersController::class, 'create'])->name('customers.customer.create');
        Route::get('/show/{customer}', [CustomersController::class, 'show'])->name('customers.customer.show')->where('id', '[0-9]+');
        Route::get('/{customer}/edit', [CustomersController::class, 'edit'])->name('customers.customer.edit')->where('id', '[0-9]+');
        Route::get('/{customer}/advance-info', [CustomersController::class, 'advanceInfo'])->name('customers.customer.advance_info')->where('id', '[0-9]+');
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
        Route::get('/{vendor}/advance-info', [VendorsController::class, 'advanceInfo'])->name('vendors.vendor.advance_info')->where('id', '[0-9]+');
        Route::post('/', [VendorsController::class, 'store'])->name('vendors.vendor.store');
        Route::put('vendor/{vendor}', [VendorsController::class, 'update'])->name('vendors.vendor.update')->where('id', '[0-9]+');
        Route::delete('/vendor/{vendor}', [VendorsController::class, 'destroy'])->name('vendors.vendor.destroy')->where('id', '[0-9]+');
    });


// php artisan resource-file:create Invoice --fields=id,customer_id,invoice_number,order_number,invoice_date,payment_terms,due_date,sub_total,total,discount_type,discount_value,discount,shipping_charge,terms_condition
// php artisan create:scaffold Invoice  --layout-name="layouts.app" --with-migration


    Route::group(['prefix' => 'invoices'], function () {

        Route::get('/', [InvoicesController::class, 'index'])->name('invoices.invoice.index');
        Route::get('/create', [InvoicesController::class, 'create'])->name('invoices.invoice.create');
        Route::get('/items/{invoice}', [InvoicesController::class, 'items'])->name('invoices.invoice.items');
        Route::get('/show/{invoice}', [InvoicesController::class, 'show'])->name('invoices.invoice.show')->where('id', '[0-9]+');
        Route::get('/share/{invoice}', [InvoicesController::class, 'share'])->name('invoices.invoice.share')->where('id', '[0-9]+')->withoutMiddleware('auth:web');
        Route::get('/send/{invoice}', [InvoicesController::class, 'send'])->name('invoices.invoice.send')->where('id', '[0-9]+');
        Route::get('/{invoice}/edit', [InvoicesController::class, 'edit'])->name('invoices.invoice.edit')->where('id', '[0-9]+');
        Route::post('/', [InvoicesController::class, 'store'])->name('invoices.invoice.store');
        Route::post('/send/{invoice}', [InvoicesController::class, 'sendInvoiceMail'])->name('invoices.invoice.send_invoice_mail');
        Route::put('invoice/{invoice}', [InvoicesController::class, 'update'])->name('invoices.invoice.update')->where('id', '[0-9]+');
        Route::delete('/invoice/{invoice}', [InvoicesController::class, 'destroy'])->name('invoices.invoice.destroy')->where('id', '[0-9]+');

    });


    Route::group(['prefix' => 'sales_returns'], function () {

        Route::get('/', [SalesReturnsController::class, 'index'])->name('sales_returns.sales_return.index');
        Route::get('/create', [SalesReturnsController::class, 'create'])->name('sales_returns.sales_return.create');
        Route::get('/show/{invoice}', [SalesReturnsController::class, 'show'])->name('sales_returns.sales_return.show')->where('id', '[0-9]+');
        Route::get('/{invoice}/edit', [SalesReturnsController::class, 'edit'])->name('sales_returns.sales_return.edit')->where('id', '[0-9]+');
        Route::post('/', [SalesReturnsController::class, 'store'])->name('sales_returns.sales_return.store');
        Route::put('invoice/{invoice}', [SalesReturnsController::class, 'update'])->name('sales_returns.sales_return.update')->where('id', '[0-9]+');
        Route::delete('/invoice/{invoice}', [SalesReturnsController::class, 'destroy'])->name('sales_returns.sales_return.destroy')->where('id', '[0-9]+');

    });

    Route::group(['prefix' => 'purchase_returns'], function () {

        Route::get('/', [PurchaseReturnsController::class, 'index'])->name('purchase_returns.purchase_return.index');
        Route::get('/create', [PurchaseReturnsController::class, 'create'])->name('purchase_returns.purchase_return.create');
        Route::get('/show/{invoice}', [PurchaseReturnsController::class, 'show'])->name('purchase_returns.purchase_return.show')->where('id', '[0-9]+');
        Route::get('/{invoice}/edit', [PurchaseReturnsController::class, 'edit'])->name('purchase_returns.purchase_return.edit')->where('id', '[0-9]+');
        Route::post('/', [PurchaseReturnsController::class, 'store'])->name('purchase_returns.purchase_return.store');
        Route::put('invoice/{invoice}', [PurchaseReturnsController::class, 'update'])->name('purchase_returns.purchase_return.update')->where('id', '[0-9]+');
        Route::delete('/invoice/{invoice}', [PurchaseReturnsController::class, 'destroy'])->name('purchase_returns.purchase_return.destroy')->where('id', '[0-9]+');

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
        Route::get('/items/{bill}', [BillsController::class, 'items'])->name('bills.bill.items');

    });
    Route::group(['prefix' => 'contact_invoices'], function () {

        Route::get('/', [ContactInvoiceController::class, 'index'])->name('contact_invoices.contact_invoice.index');
        Route::get('/create', [ContactInvoiceController::class, 'create'])->name('contact_invoices.contact_invoice.create');
        Route::get('/show/{contact_invoice}', [ContactInvoiceController::class, 'show'])->name('contact_invoices.contact_invoice.show')->where('id', '[0-9]+');
        Route::get('/share/{contact_invoice}', [ContactInvoiceController::class, 'share'])->name('contact_invoices.contact_invoice.share')->where('id', '[0-9]+')->withoutMiddleware('auth:web');
        Route::get('/send/{contact_invoice}', [ContactInvoiceController::class, 'send'])->name('contact_invoices.contact_invoice.send')->where('id', '[0-9]+');
        Route::get('/{contact_invoice}/edit', [ContactInvoiceController::class, 'edit'])->name('contact_invoices.contact_invoice.edit')->where('id', '[0-9]+');
        Route::post('/', [ContactInvoiceController::class, 'store'])->name('contact_invoices.contact_invoice.store');
        Route::post('/send/{contact_invoice}', [ContactInvoiceController::class, 'sendBillMail'])->name('contact_invoices.contact_invoice.send_bill_mail');
        Route::put('contact_invoice/{contact_invoice}', [ContactInvoiceController::class, 'update'])->name('contact_invoices.contact_invoice.update')->where('id', '[0-9]+');
        Route::delete('/contact_invoice/{contact_invoice}', [ContactInvoiceController::class, 'destroy'])->name('contact_invoices.contact_invoice.destroy')->where('id', '[0-9]+');
        Route::get('/items/{contact-invoice}', [ContactInvoiceController::class, 'items'])->name('contact_invoices.contact_invoice.items');

    });

    Route::group(['prefix' => 'purchase_orders'], function () {

        Route::get('/', [PurchaseOrdersController::class, 'index'])->name('purchase_orders.purchase_order.index');
        Route::get('/create', [PurchaseOrdersController::class, 'create'])->name('purchase_orders.purchase_order.create');
        Route::get('/show/{purchase_order}', [PurchaseOrdersController::class, 'show'])->name('purchase_orders.purchase_order.show')->where('id', '[0-9]+');
        Route::get('/convert_to_bill/{purchase_order}', [PurchaseOrdersController::class, 'convert_to_bill'])->name('purchase_orders.purchase_order.convert_to_bill')->where('id', '[0-9]+');
        Route::get('/share/{purchase_order}', [PurchaseOrdersController::class, 'share'])->name('purchase_orders.purchase_order.share')->where('id', '[0-9]+')->withoutMiddleware('auth:web');
        Route::get('/send/{purchase_order}', [PurchaseOrdersController::class, 'send'])->name('purchase_orders.purchase_order.send')->where('id', '[0-9]+');
        Route::get('/{purchase_order}/edit', [PurchaseOrdersController::class, 'edit'])->name('purchase_orders.purchase_order.edit')->where('id', '[0-9]+');
        Route::post('/', [PurchaseOrdersController::class, 'store'])->name('purchase_orders.purchase_order.store');
        Route::post('/send/{purchase_order}', [PurchaseOrdersController::class, 'sendBillMail'])->name('purchase_orders.purchase_order.send_bill_mail');
        Route::put('purchase_order/{purchase_order}', [PurchaseOrdersController::class, 'update'])->name('purchase_orders.purchase_order.update')->where('id', '[0-9]+');
        Route::delete('/purchase_order/{purchase_order}', [PurchaseOrdersController::class, 'destroy'])->name('purchase_orders.purchase_order.destroy')->where('id', '[0-9]+');

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


    Route::group(['prefix' => 'brands'], function () {

        Route::get('/', [BrandsController::class, 'index'])->name('brands.brand.index');
        Route::get('/create', [BrandsController::class, 'create'])->name('brands.brand.create');
        Route::get('/show/{brand}', [BrandsController::class, 'show'])->name('brands.brand.show');
        Route::get('/{brand}/edit', [BrandsController::class, 'edit'])->name('brands.brand.edit');
        Route::post('/', [BrandsController::class, 'store'])->name('brands.brand.store');
        Route::put('brand/{brand}', [BrandsController::class, 'update'])->name('brands.brand.update');
        Route::delete('/brand/{brand}', [BrandsController::class, 'destroy'])->name('brands.brand.destroy');

    });
// php artisan resource-file:create Product --fields=id,product_type,name,photo,category_id,sell_price,sell_unit,purchase_price,purchase_unit,description,is_track,opening_stock,opening_stock_price
// php artisan create:scaffold Product  --layout-name="layouts.app" --with-migration

    Route::group(['prefix' => 'products'], function () {

        Route::get('/', [ProductsController::class, 'index'])->name('products.product.index');
        Route::get('/search', [ProductsController::class, 'search'])->name('products.product.search');
        Route::get('/create', [ProductsController::class, 'create'])->name('products.product.create');
        Route::get('/import', [ProductsController::class, 'import'])->name('products.product.import');
        Route::get('/barcode_size', [ProductsController::class, 'barcode_size'])->name('products.product.barcode_size');
        Route::get('/show/{product}', [ProductsController::class, 'show'])->name('products.product.show')->where('id', '[0-9]+');
        Route::get('/{product}/edit', [ProductsController::class, 'edit'])->name('products.product.edit')->where('id', '[0-9]+');
        Route::get('/bookmark', [ProductsController::class, 'bookmark'])->name('products.product.bookmark');
        Route::get('/barcode', [ProductsController::class, 'barcode'])->name('products.product.barcode');
        Route::get('/export', [ProductsController::class, 'export'])->name('products.product.export');
        Route::post('/import', [ProductsController::class, 'import'])->name('products.product.import');
        Route::post('/stocks', [ProductsController::class, 'productStock'])->name('products.product.product_stock');
        Route::post('/', [ProductsController::class, 'store'])->name('products.product.store');
        Route::put('product/{product}', [ProductsController::class, 'update'])->name('products.product.update')->where('id', '[0-9]+');
        Route::post('product/{product}/updateBarcode', [ProductsController::class, 'updateBarcode'])->name('products.product.updateBarcode')->where('id', '[0-9]+');
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
        Route::post('/contact-invoice-payment', [AjaxController::class, 'contactInvoicePayment'])->name('ajax.contactInvoicePayment');
        Route::post('/settings/phoneNumber', [AjaxController::class, 'storePhoneNumber'])->name('ajax.storePhoneNumber');
        Route::post('/settings/contact-invoice', [AjaxController::class, 'storeContactInvoiceInfo'])->name('ajax.storeContactInvoiceInfo');
        Route::get('/customer-payment-receipt/{id}', [AjaxController::class, 'customerPaymentReceipt'])->name('ajax.customerPaymentReceipt');
        Route::get('/invoice-summary-report', [AjaxController::class, 'invoice_summary'])->name('ajax.invoiceSummaryReport');
        Route::get('/bill-summary-report', [AjaxController::class, 'bill_summary'])->name('ajax.billSummaryReport');
        Route::get('/today-report', [AjaxController::class, 'today_report'])->name('ajax.todayReport');
        Route::get('/withdraw-funds', [AjaxController::class, 'withdrawFund'])->name('ajax.withdrawFund');
        Route::get('/pos-create-data', [AjaxController::class, 'posCreateData'])->name('ajax.posCreateData');
        Route::post('/toggle-ads-settings', [AjaxController::class, 'toggleAdSettings'])->name('ajax.toggleAdSettings');
        Route::post('/product-batch', [AjaxController::class, 'productBatch'])->name('ajax.productBatch');
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
        Route::get('/refer_earn', [SettingsController::class, 'referEarn'])->name('settings.refer_earn');
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
        Route::get('/stock-report-details', [ReportController::class, 'stockReportDetails'])->name('reports.report.stock-report-details');
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
        Route::get('/sales-report-details', [ReportController::class, 'salesReportDetails'])->name('reports.report.sales_report_details');
        Route::get('/purchase-report', [ReportController::class, 'purchaseReport'])->name('reports.report.purchase_report');
        Route::get('/purchase-report-details', [ReportController::class, 'purchaseReportDetails'])->name('reports.report.purchase_report_details');
        Route::get('/due-collection-report', [ReportController::class, 'dueCollectionReport'])->name('reports.report.due_collection_report');
        Route::get('/due-payment-report', [ReportController::class, 'duePaymentReport'])->name('reports.report.due_payment_report');
        Route::get('/product-report', [ReportController::class, 'productReport'])->name('reports.report.product_report');
        Route::get('/customer-report', [ReportController::class, 'customerReport'])->name('reports.report.customer_report');
        Route::get('/vendor-report', [ReportController::class, 'vendorReport'])->name('reports.report.vendor_report');
        Route::get('/product-expiry-report', [ReportController::class, 'productExpiryReport'])->name('reports.report.product_expiry_report');
        Route::get('/stock-alert-report', [ReportController::class, 'stockAlert'])->name('reports.report.stock_alert');
        Route::get('/stock-alert-report-modal', [ReportController::class, 'stockAlertModal'])->name('reports.report.stock_alert_modal');
        Route::get('/popular-products-report', [ReportController::class, 'popularProductReport'])->name('reports.report.popular_products_report');

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

        Route::get('/', [PosSalesController::class, 'index'])->name('pos_sales.pos_sale.index');
        Route::get('/create', [PosSalesController::class, 'create'])->name('pos_sales.pos_sale.create');
        Route::get('/show/{posSale}', [PosSalesController::class, 'show'])->name('pos_sales.pos_sale.show')->where('id', '[0-9]+');
        Route::get('/details', [PosSalesController::class, 'details'])->name('pos_sales.pos_sale.details')->where('id', '[0-9]+');
        Route::post('/eye/{posSale}', [PosSalesController::class, 'eye'])->name('pos_sales.pos_sale.eye')->where('id', '[0-9]+');
        Route::get('/{posSale}/edit', [PosSalesController::class, 'edit'])->name('pos_sales.pos_sale.edit')->where('id', '[0-9]+');
        Route::post('/', [PosSalesController::class, 'store'])->name('pos_sales.pos_sale.store');
        Route::post('/pay', [PosSalesController::class, 'pay'])->name('pos_sales.pos_sale.pay');
        Route::post('/filter', [PosSalesController::class, 'filter'])->name('pos_sales.pos_sale.filter');
        Route::put('pos_sale/{posSale}', [PosSalesController::class, 'update'])->name('pos_sales.pos_sale.update')->where('id', '[0-9]+');
        Route::delete('/pos_sale/{posSale}', [PosSalesController::class, 'destroy'])->name('pos_sales.pos_sale.destroy')->where('id', '[0-9]+');

    });

    /*
 *  php artisan resource-file:create SR --fields=id,name,photo,phone,email,address
 *  php artisan create:scaffold SR  --layout-name="layouts.app" --with-migration
 * */

    Route::group(['prefix' => 's_rs'], function () {
        Route::get('/', [SRsController::class, 'index'])->name('s_rs.s_r.index');
        Route::get('/create', [SRsController::class, 'create'])->name('s_rs.s_r.create');
        Route::get('/show/{sR}', [SRsController::class, 'show'])->name('s_rs.s_r.show')->where('id', '[0-9]+');
        Route::get('/{sR}/edit', [SRsController::class, 'edit'])->name('s_rs.s_r.edit')->where('id', '[0-9]+');
        Route::post('/', [SRsController::class, 'store'])->name('s_rs.s_r.store');
        Route::put('s_r/{sR}', [SRsController::class, 'update'])->name('s_rs.s_r.update')->where('id', '[0-9]+');
        Route::delete('/s_r/{sR}', [SRsController::class, 'destroy'])->name('s_rs.s_r.destroy')->where('id', '[0-9]+');

    });
    /*
     *  php artisan resource-file:create CustomerAdvancePayment --fields=id,customer_id,ledger_id,amount,date,note,user_id,client_id
     *  php artisan create:scaffold CustomerAdvancePayment  --layout-name="acc::layouts.app" --with-migration
     *
     * */

    Route::group(['prefix' => 'customer_advance_payments'], function () {

        Route::get('/', [CustomerAdvancePaymentsController::class, 'index'])->name('customer_advance_payments.customer_advance_payment.index');
        Route::get('/create', [CustomerAdvancePaymentsController::class, 'create'])->name('customer_advance_payments.customer_advance_payment.create');
        Route::get('/show/{customerAdvancePayment}', [CustomerAdvancePaymentsController::class, 'show'])->name('customer_advance_payments.customer_advance_payment.show')->where('id', '[0-9]+');
        Route::get('/{customerAdvancePayment}/edit', [CustomerAdvancePaymentsController::class, 'edit'])->name('customer_advance_payments.customer_advance_payment.edit')->where('id', '[0-9]+');
        Route::post('/', [CustomerAdvancePaymentsController::class, 'store'])->name('customer_advance_payments.customer_advance_payment.store');
        Route::put('customer_advance_payment/{customerAdvancePayment}', [CustomerAdvancePaymentsController::class, 'update'])->name('customer_advance_payments.customer_advance_payment.update')->where('id', '[0-9]+');
        Route::delete('/customer_advance_payment/{customerAdvancePayment}', [CustomerAdvancePaymentsController::class, 'destroy'])->name('customer_advance_payments.customer_advance_payment.destroy')->where('id', '[0-9]+');

    });

    /*
   *  php artisan resource-file:create VendorAdvancePayment --fields=id,vendor_id,ledger_id,amount,date,note,user_id,client_id
   *  php artisan create:scaffold VendorAdvancePayment  --layout-name="acc::layouts.app" --with-migration
   *
   * */

    Route::group(['prefix' => 'vendor_advance_payments'], function () {

        Route::get('/', [VendorAdvancePaymentsController::class, 'index'])->name('vendor_advance_payments.vendor_advance_payment.index');
        Route::get('/create', [VendorAdvancePaymentsController::class, 'create'])->name('vendor_advance_payments.vendor_advance_payment.create');
        Route::get('/show/{vendorAdvancePayment}', [VendorAdvancePaymentsController::class, 'show'])->name('vendor_advance_payments.vendor_advance_payment.show')->where('id', '[0-9]+');
        Route::get('/{vendorAdvancePayment}/edit', [VendorAdvancePaymentsController::class, 'edit'])->name('vendor_advance_payments.vendor_advance_payment.edit')->where('id', '[0-9]+');
        Route::post('/', [VendorAdvancePaymentsController::class, 'store'])->name('vendor_advance_payments.vendor_advance_payment.store');
        Route::put('vendor_advance_payment/{vendorAdvancePayment}', [VendorAdvancePaymentsController::class, 'update'])->name('vendor_advance_payments.vendor_advance_payment.update')->where('id', '[0-9]+');
        Route::delete('/vendor_advance_payment/{vendorAdvancePayment}', [VendorAdvancePaymentsController::class, 'destroy'])->name('vendor_advance_payments.vendor_advance_payment.destroy')->where('id', '[0-9]+');

    });


    /*
     *  php artisan resource-file:create Production --fields=id,ref,date,status,note
     *  php artisan create:scaffold Production  --layout-name="acc::layouts.app" --with-migration
     * */
    Route::group(['prefix' => 'productions'], function () {

        Route::get('/', [ProductionsController::class, 'index'])->name('productions.production.index');
        Route::get('/create', [ProductionsController::class, 'create'])->name('productions.production.create');
        Route::get('/show/{production}', [ProductionsController::class, 'show'])->name('productions.production.show')->where('id', '[0-9]+');
        Route::get('/{production}/edit', [ProductionsController::class, 'edit'])->name('productions.production.edit')->where('id', '[0-9]+');
        Route::post('/', [ProductionsController::class, 'store'])->name('productions.production.store');
        Route::put('production/{production}', [ProductionsController::class, 'update'])->name('productions.production.update')->where('id', '[0-9]+');
        Route::delete('/production/{production}', [ProductionsController::class, 'destroy'])->name('productions.production.destroy')->where('id', '[0-9]+');

    });


    /*
     *
  *  php artisan resource-file:create StockEntry --fields=id,ref,date,brand_id,category_id,product_id
  *  php artisan create:scaffold StockEntry  --layout-name="acc::layouts.app" --with-migration
  *
 * */

    Route::group(['prefix' => 'stock_entries'], function () {

        Route::get('/', [StockEntriesController::class, 'index'])->name('stock_entries.stock_entry.index');
        Route::get('/create', [StockEntriesController::class, 'create'])->name('stock_entries.stock_entry.create');
        Route::get('/show/{stockEntry}', [StockEntriesController::class, 'show'])->name('stock_entries.stock_entry.show')->where('id', '[0-9]+');
        Route::get('/{stockEntry}/edit', [StockEntriesController::class, 'edit'])->name('stock_entries.stock_entry.edit')->where('id', '[0-9]+');
        Route::post('/', [StockEntriesController::class, 'store'])->name('stock_entries.stock_entry.store');
        Route::put('stock_entry/{stockEntry}', [StockEntriesController::class, 'update'])->name('stock_entries.stock_entry.update')->where('id', '[0-9]+');
        Route::delete('/stock_entry/{stockEntry}', [StockEntriesController::class, 'destroy'])->name('stock_entries.stock_entry.destroy')->where('id', '[0-9]+');

    });


    /*
    *
    *  php artisan resource-file:from-database User
    *  php artisan create:scaffold User  --layout-name="acc::layouts.app"
    *
    *
    * */


    Route::group(['prefix' => 'users'], function () {

        Route::get('/', [UsersController::class, 'index'])->name('users.user.index');
        Route::get('/create', [UsersController::class, 'create'])->name('users.user.create');
//        Route::get('/ad-settings', [UsersController::class, 'create'])->name('users.user.create');
        Route::get('/show/{user}', [UsersController::class, 'show'])->name('users.user.show');
        Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.user.edit');
        Route::post('/', [UsersController::class, 'store'])->name('users.user.store');
        Route::put('user/{user}', [UsersController::class, 'update'])->name('users.user.update');
        Route::delete('/user/{user}', [UsersController::class, 'destroy'])->name('users.user.destroy');

    });


    /*
     *  php artisan resource-file:create UserRole --fields=id,name,description,payload
     *  php artisan create:scaffold UserRole  --layout-name="acc::layouts.app" --with-migration
     * */
    Route::group(['prefix' => 'user_roles'], function () {

        Route::get('/', [UserRolesController::class, 'index'])->name('user_roles.user_role.index');
        Route::get('/create', [UserRolesController::class, 'create'])->name('user_roles.user_role.create');
        Route::get('/show/{userRole}', [UserRolesController::class, 'show'])->name('user_roles.user_role.show')->where('id', '[0-9]+');
        Route::get('/{userRole}/edit', [UserRolesController::class, 'edit'])->name('user_roles.user_role.edit')->where('id', '[0-9]+');
        Route::post('/', [UserRolesController::class, 'store'])->name('user_roles.user_role.store');
        Route::put('user_role/{userRole}', [UserRolesController::class, 'update'])->name('user_roles.user_role.update')->where('id', '[0-9]+');
        Route::delete('/user_role/{userRole}', [UserRolesController::class, 'destroy'])->name('user_roles.user_role.destroy')->where('id', '[0-9]+');

    });


    /*
     *
     *  php artisan resource-file:create Shortcut --fields=id,name,link
     *  php artisan create:scaffold Shortcut  --layout-name="acc::layouts.app" --with-migration
     *
     * */
    Route::group(['prefix' => 'shortcuts'], function () {

        Route::get('/', [ShortcutsController::class, 'index'])->name('shortcuts.shortcut.index');
        Route::get('/create', [ShortcutsController::class, 'create'])->name('shortcuts.shortcut.create');
        Route::get('/show/{shortcut}', [ShortcutsController::class, 'show'])->name('shortcuts.shortcut.show')->where('id', '[0-9]+');
        Route::get('/{shortcut}/edit', [ShortcutsController::class, 'edit'])->name('shortcuts.shortcut.edit')->where('id', '[0-9]+');
        Route::post('/', [ShortcutsController::class, 'store'])->name('shortcuts.shortcut.store');
        Route::put('shortcut/{shortcut}', [ShortcutsController::class, 'update'])->name('shortcuts.shortcut.update')->where('id', '[0-9]+');
        Route::delete('/shortcut/{shortcut}', [ShortcutsController::class, 'destroy'])->name('shortcuts.shortcut.destroy')->where('id', '[0-9]+');

    });
});


/*
 *  php artisan resource-file:create Blog --fields=id,title,slug,body,user_id,client_id
 *  php artisan create:scaffold Blog  --layout-name="layouts.app" --with-migration
 *
 * */

Route::view('/instant-invoice', 'instant-invoice');
Route::get('p/{slug}', [BlogsController::class, 'show'])->name('blogs.blog.show')->where('id', '[0-9]+');


Route::group(['prefix' => 'master', 'middleware' => ['auth:web', 'isMaster']], function () {

    Route::get('/', [MasterController::class, 'index'])->name('master.index');
    Route::get('/user_settings_view', [MasterController::class, 'user_settings_view'])->name('master.user_settings');
    Route::post('/user_settings', [MasterController::class, 'user_settings'])->name('master.user_settings_store');
    Route::get('/subscriptions', [MasterController::class, 'subscriptions'])->name('master.subscriptions');
    Route::post('/subscriptions/free-plan', [MasterController::class, 'freePlanSettings'])->name('master.subscriptions.free_plan');
    Route::post('/subscriptions/basic-plan', [MasterController::class, 'basicPlanSettings'])->name('master.subscriptions.basic_plan');
    Route::post('/subscriptions/premium-plan', [MasterController::class, 'premiumPlanSettings'])->name('master.subscriptions.premium_plan');
    Route::get('/users', [MasterController::class, 'users'])->name('master.users');
    Route::get('/users/{user}', [MasterController::class, 'deleteUser'])->name('master.users.delete');


    Route::group(['prefix' => 'blog_categories'], function () {

        Route::get('/', [BlogCategoriesController::class, 'index'])->name('blog.category.index');
        Route::get('/create', [BlogCategoriesController::class, 'create'])->name('blog.category.create');
        Route::get('/show/{category}', [BlogCategoriesController::class, 'show'])->name('blog.category.show')->where('id', '[0-9]+');
        Route::get('/{category}/edit', [BlogCategoriesController::class, 'edit'])->name('blog.category.edit')->where('id', '[0-9]+');
        Route::post('/', [BlogCategoriesController::class, 'store'])->name('blog.category.store');
        Route::put('category/{category}', [BlogCategoriesController::class, 'update'])->name('blog.category.update')->where('id', '[0-9]+');
        Route::delete('/category/{category}', [BlogCategoriesController::class, 'destroy'])->name('blog.category.destroy')->where('id', '[0-9]+');

    });




    Route::group(['prefix' => 'post'], function () {

        Route::get('/', [PostController::class, 'index'])->name('post.index');
        Route::get('/create', [PostController::class, 'create'])->name('post.create');
        Route::get('/show/{category}', [PostController::class, 'show'])->name('post.show')->where('id', '[0-9]+');
        Route::get('/{category}/edit', [PostController::class, 'edit'])->name('post.edit')->where('id', '[0-9]+');
        Route::post('/', [PostController::class, 'store'])->name('post.store');
        Route::put('post/{id}', [PostController::class, 'update'])->name('post.update')->where('id', '[0-9]+');
        Route::delete('/category/{category}', [PostController::class, 'destroy'])->name('post.destroy')->where('id', '[0-9]+');

    });




    /*
     *  php artisan resource-file:create BannerAd --fields=id,title,image,link,banner_type
     *  php artisan create:scaffold BannerAd  --layout-name="master.master-layout" --with-migration
     *
     * */


    Route::group(['prefix' => 'banner_ads'], function () {
        Route::get('/', [BannerAdsController::class, 'index'])->name('banner_ads.banner_ad.index');
        Route::get('/create', [BannerAdsController::class, 'create'])->name('banner_ads.banner_ad.create');
        Route::get('/show/{bannerAd}', [BannerAdsController::class, 'show'])->name('banner_ads.banner_ad.show')->where('id', '[0-9]+');
        Route::get('/{bannerAd}/edit', [BannerAdsController::class, 'edit'])->name('banner_ads.banner_ad.edit')->where('id', '[0-9]+');
        Route::post('/', [BannerAdsController::class, 'store'])->name('banner_ads.banner_ad.store');
        Route::put('banner_ad/{bannerAd}', [BannerAdsController::class, 'update'])->name('banner_ads.banner_ad.update')->where('id', '[0-9]+');
        Route::delete('/banner_ad/{bannerAd}', [BannerAdsController::class, 'destroy'])->name('banner_ads.banner_ad.destroy')->where('id', '[0-9]+');

    });


    Route::group(['prefix' => 'blogs'], function () {


        Route::get('/', [BlogsController::class, 'index'])->name('blogs.blog.index');
        Route::get('/create', [BlogsController::class, 'create'])->name('blogs.blog.create');
        Route::get('/{blog}/edit', [BlogsController::class, 'edit'])->name('blogs.blog.edit')->where('id', '[0-9]+');
        Route::post('/', [BlogsController::class, 'store'])->name('blogs.blog.store');
        Route::put('blog/{blog}', [BlogsController::class, 'update'])->name('blogs.blog.update')->where('id', '[0-9]+');
        Route::delete('/blog/{blog}', [BlogsController::class, 'destroy'])->name('blogs.blog.destroy')->where('id', '[0-9]+');

    });

    Route::group(['prefix' => 'blog_tags'], function () {

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

    /*
    *
    * php artisan resource-file:create CollectPayment --fields=id,date,for_month,user_id,amount,referred_by,referred_by_amount,note
    * php artisan create:scaffold CollectPayment  --layout-name="master.master-layout" --with-migration
    */
    Route::group(['prefix' => 'collect_payments'], function () {

        Route::get('/', [CollectPaymentsController::class, 'index'])->name('collect_payments.collect_payment.index');
        Route::get('/create', [CollectPaymentsController::class, 'create'])->name('collect_payments.collect_payment.create');
        Route::get('/show/{collectPayment}', [CollectPaymentsController::class, 'show'])->name('collect_payments.collect_payment.show')->where('id', '[0-9]+');
        Route::get('/{collectPayment}/edit', [CollectPaymentsController::class, 'edit'])->name('collect_payments.collect_payment.edit')->where('id', '[0-9]+');
        Route::post('/', [CollectPaymentsController::class, 'store'])->name('collect_payments.collect_payment.store');
        Route::put('collect_payment/{collectPayment}', [CollectPaymentsController::class, 'update'])->name('collect_payments.collect_payment.update')->where('id', '[0-9]+');
        Route::delete('/collect_payment/{collectPayment}', [CollectPaymentsController::class, 'destroy'])->name('collect_payments.collect_payment.destroy')->where('id', '[0-9]+');

    });

    Route::group(['prefix' => 'user_notifications'], function () {

        Route::get('/', [UserNotificationsController::class, 'index'])->name('user_notifications.user_notification.index');
        Route::get('/seen', [UserNotificationsController::class, 'markSeen'])->name('user_notifications.user_notification.mark-seen')->withoutMiddleware('isMaster');
        Route::get('/create', [UserNotificationsController::class, 'create'])->name('user_notifications.user_notification.create');
        Route::get('/show/{userNotification}', [UserNotificationsController::class, 'show'])->name('user_notifications.user_notification.show')->where('id', '[0-9]+');
        Route::get('/{userNotification}/edit', [UserNotificationsController::class, 'edit'])->name('user_notifications.user_notification.edit')->where('id', '[0-9]+');
        Route::post('/', [UserNotificationsController::class, 'store'])->name('user_notifications.user_notification.store');
        Route::put('user_notification/{userNotification}', [UserNotificationsController::class, 'update'])->name('user_notifications.user_notification.update')->where('id', '[0-9]+');
        Route::delete('/user_notification/{userNotification}', [UserNotificationsController::class, 'destroy'])->name('user_notifications.user_notification.destroy')->where('id', '[0-9]+');

    });

    /*
*
* php artisan resource-file:create PaymentRequest --fields=id,date,user_id,amount,status,note
* php artisan create:scaffold PaymentRequest  --layout-name="master.master-layout" --with-migration --views-directory=master
*/

    Route::group(['prefix' => 'payment_requests'], function () {

        Route::get('/', [PaymentRequestsController::class, 'index'])->name('payment_requests.payment_request.index');
        Route::get('/create', [PaymentRequestsController::class, 'create'])->name('payment_requests.payment_request.create');
        Route::get('/show/{paymentRequest}', [PaymentRequestsController::class, 'show'])->name('payment_requests.payment_request.show')->where('id', '[0-9]+');
        Route::get('/{paymentRequest}/edit', [PaymentRequestsController::class, 'edit'])->name('payment_requests.payment_request.edit')->where('id', '[0-9]+');
        Route::post('/', [PaymentRequestsController::class, 'store'])->name('payment_requests.payment_request.store');
        Route::put('payment_request/{paymentRequest}', [PaymentRequestsController::class, 'update'])->name('payment_requests.payment_request.update')->where('id', '[0-9]+');
        Route::delete('/payment_request/{paymentRequest}', [PaymentRequestsController::class, 'destroy'])->name('payment_requests.payment_request.destroy')->where('id', '[0-9]+');

    });
});
Route::get('master/users/login/{email}', [MasterController::class, 'loginClient'])->name('master.users.login');


Route::get('/task', function () {
//    MetaSetting::query()->updateOrCreate(['key' => 'plan_name'], ['value' => null]);

    dd('test');
    $notification = new NotificationController;
    $notification->testEmail();
    dd(array_merge(['KG', 'M', 'CM', 'BOX', 'LT.'], ProductUnit::query()->pluck('name')->unique()->toArray()));

    foreach (User::all() as $user) {
        Auth::login($user);
        foreach (Customer::all() as $customer) {
            Transaction::query()->where('type', Customer::class)->where('type_id', $customer->id)->delete();
            TransactionDetail::query()->where('type', Customer::class)->where('type_id', $customer->id)->where('ledger_id', Ledger::ACCOUNTS_RECEIVABLE())->delete();
            $customerController = new CustomersController();
            $customerController->createOrUpdateLedger($customer);
        }
        foreach (Vendor::all() as $vendor) {
            Transaction::query()->where('type', Vendor::class)->where('type_id', $vendor->id)->delete();
            TransactionDetail::query()->where('type', Vendor::class)->where('type_id', $vendor->id)->where('ledger_id', Ledger::ACCOUNTS_RECEIVABLE())->delete();
            $vendorController = new VendorsController();
            $vendorController->createOrUpdateLedger($vendor);
        }
        foreach (Invoice::all() as $invoice) {
            $customer = $invoice->customer ?? Customer::WALKING_CUSTOMER();
            TransactionDetail::query()->where(['type' => get_class($invoice), 'type_id' => $invoice->id, 'ledger_id' => Ledger::ACCOUNTS_RECEIVABLE()])->update(['ledger_id' => optional($customer->ledger)->id]);
        }
        foreach (ReceivePaymentItem::all() as $receivePaymentItem) {
            $customer = $receivePaymentItem->invoice->customer ?? Customer::WALKING_CUSTOMER();
            TransactionDetail::query()->where(['type' => get_class($receivePaymentItem), 'type_id' => $receivePaymentItem->id, 'ledger_id' => Ledger::ACCOUNTS_RECEIVABLE()])->update(['ledger_id' => optional($customer->ledger)->id]);
        }
        foreach (Bill::all() as $bill) {
            $vendor = $bill->vendor;
            if ($vendor == null) continue;
            TransactionDetail::query()->where([
                'type' => get_class($bill),
                'type_id' => $bill->id,
                'ledger_id' => Ledger::ACCOUNTS_PAYABLE()])->update(
                ['ledger_id' => optional($vendor->ledger)->id]
            );
        }
        foreach (BillPaymentItem::all() as $billPaymentItem) {
            $vendor = $billPaymentItem->bill->vendor;
            if ($vendor == null) continue;
            TransactionDetail::query()->where([
                'type' => get_class($receivePaymentItem),
                'type_id' => $receivePaymentItem->id,
                'ledger_id' => Ledger::ACCOUNTS_PAYABLE()])->update(
                ['ledger_id' => optional($vendor->ledger)->id]);
        }

        foreach (PosSale::all() as $invoice) {
            $customer = $invoice->customer ?? Customer::WALKING_CUSTOMER();
//            dump($customer);
            $d = TransactionDetail::query()->where(['type' => get_class($invoice), 'type_id' => $invoice->id, 'ledger_id' => Ledger::ACCOUNTS_RECEIVABLE()])
                ->update(['ledger_id' => optional($customer->ledger)->id]);
        }
        foreach (\App\Models\PosPayment::all() as $receivePaymentItem) {
            $customer = $receivePaymentItem->pos_sale->customer ?? Customer::WALKING_CUSTOMER();
            TransactionDetail::query()->where(['type' => get_class($receivePaymentItem), 'type_id' => $receivePaymentItem->id, 'ledger_id' => Ledger::ACCOUNTS_RECEIVABLE()])->update(['ledger_id' => optional($customer->ledger)->id]);
        }

    }


    dd('task completed');
});


Route::get('/app/pos_sales/receipt/{id}', [PosSalesController::class, 'pos_receipt_public'])->name('pos_sales.pos_sale.receipt');

Route::get('/clear-cache', function () {

    DB::transaction(function () {
        foreach (User::all() as $user) {
            $user->plan_type = strtolower($user->settings->plan_name);
            $user->save();
        }
    });


    return back();

})->name('clear_cache');

// php artisan resource-file:create UserNotification --fields=id,type,title,body,user_id,seen
//  php artisan create:scaffold UserNotification  --layout-name="master.master-layout" --with-migration




Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
