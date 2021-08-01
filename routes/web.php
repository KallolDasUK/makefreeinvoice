<?php

use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\Estimates\EstimatesController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\ReceivePaymentsController;
use App\Http\Controllers\PaymentMethodsController;
use App\Models\Estimate;
use Illuminate\Support\Facades\Route;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;

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
    return view('landing.welcome');
});

Auth::routes();
Route::get('/auth/redirect/{provider}', [SocialLoginController::class, 'redirect'])->name('social.redirect');
Route::get('/auth/callback/{provider}', [SocialLoginController::class, 'callback'])->name('social.callback');

Route::group(['middleware' => 'auth:web'], function () {


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

    Route::group(['prefix' => 'payment_methods'], function () {

        Route::get('/', [PaymentMethodsController::class, 'index'])->name('payment_methods.payment_method.index');
        Route::get('/create', [PaymentMethodsController::class, 'create'])->name('payment_methods.payment_method.create');
        Route::get('/show/{paymentMethod}', [PaymentMethodsController::class, 'show'])->name('payment_methods.payment_method.show');
        Route::get('/{paymentMethod}/edit', [PaymentMethodsController::class, 'edit'])->name('payment_methods.payment_method.edit');
        Route::post('/', [PaymentMethodsController::class, 'store'])->name('payment_methods.payment_method.store');
        Route::put('payment_method/{paymentMethod}', [PaymentMethodsController::class, 'update'])->name('payment_methods.payment_method.update');
        Route::delete('/payment_method/{paymentMethod}', [PaymentMethodsController::class, 'destroy'])->name('payment_methods.payment_method.destroy');

    });

    Route::group(['prefix' => 'ajax'], function () {
        Route::post('/receive-payment-customers-invoice', [AjaxController::class, 'receivePaymentCustomerInvoice'])->name('receive-payment-customers-invoice');
        Route::post('/record-payment', [AjaxController::class, 'recordPayment'])->name('ajax.recordPayment');
    });
});
Route::get('/test', function () {

    $estimate = Estimate::query()->first();


    return view('mail.estimate-mail',compact('estimate'));
});


