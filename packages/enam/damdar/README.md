### Read Carefully

``composer require kinetixbd/acc``

Add this code in app/app.php's provider array
 
```
'providers' => [
 ...,
 Enam\Acc\AccountingServiceProvider::class 
 ]
 ```

Publish the migrations, run
    
    php artisan vendor:publish --provider=Enam\Acc\AccountingServiceProvider

run the migrations, run

    php artisan migrate
    

Example 

```
    $vno = Accounting::generateUniqueVoucher();
    Accounting::makeTransaction("c_5", Accounting::$PRODUCT_SALES, $vno, 0, 50, null, 'Ops', Carbon::today()->subDays(5));
    Accounting::makeTransaction("c_5", Accounting::$CASH_IN_HAND, $vno, 50, 0, null, 'Hahah', Carbon::today()->subDays(5));
    Accounting::makeHeadIfNotExists('Product Sales', 'Sales', 'Expense');
    Accounting::makeHeadIfNotExists('Cash In Hand', 'Cash', 'Income');
```

