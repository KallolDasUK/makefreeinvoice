<?php

use Enam\Acc\Http\Controllers\AccHomeController;
use Enam\Acc\Http\Controllers\AccountingReportsController;
use Enam\Acc\Http\Controllers\BaseController as BaseControllerAlias;
use Enam\Acc\Http\Controllers\ContrasController;
use Enam\Acc\Http\Controllers\JournalsController;
use Enam\Acc\Http\Controllers\SettingsController;
use Enam\Acc\Http\Controllers\TransactionsController;
use Enam\Acc\Http\Controllers\PaymentsController;
use Illuminate\Support\Facades\Route;
use Enam\Acc\Http\Controllers\LedgerGroupsController;
use Enam\Acc\Http\Controllers\LedgersController;
use Enam\Acc\Http\Controllers\BranchesController;

Route::middleware(['web', 'auth:web'])
    ->group(function () {

        Route::get('/accounting', [BaseControllerAlias::class, 'index'])->name('acc.home');

        /*############ Accounting #######*/

        /* Master */

        Route::get('/coa', [BaseControllerAlias::class, 'coa'])->name('accounting.coa');

        Route::group(['prefix' => 'ledger_groups'], function () {
            Route::get('/', [LedgerGroupsController::class, 'index'])->name('ledger_groups.ledger_group.index');
            Route::get('/trash', [LedgerGroupsController::class, 'trash'])->name('ledger_groups.ledger_group.trash');
            Route::get('/create', [LedgerGroupsController::class, 'create'])->name('ledger_groups.ledger_group.create');
            Route::get('/show/{ledgerGroup}', [LedgerGroupsController::class, 'show'])->name('ledger_groups.ledger_group.show');
            Route::get('/{ledgerGroup}/edit', [LedgerGroupsController::class, 'edit'])->name('ledger_groups.ledger_group.edit');
            Route::post('/', [LedgerGroupsController::class, 'store'])->name('ledger_groups.ledger_group.store');
            Route::put('ledger_group/{ledgerGroup}', [LedgerGroupsController::class, 'update'])->name('ledger_groups.ledger_group.update');
            Route::delete('/ledger_group/{ledgerGroup}', [LedgerGroupsController::class, 'destroy'])->name('ledger_groups.ledger_group.destroy');
            Route::post('/ledger_group/{ledgerGroup}', [LedgerGroupsController::class, 'restore'])->name('ledger_groups.ledger_group.restore');
        });

        Route::group(['prefix' => 'ledgers'], function () {
            Route::get('/', [LedgersController::class, 'index'])->name('ledgers.ledger.index');
            Route::get('/trash', [LedgersController::class, 'trash'])->name('ledgers.ledger.trash');
            Route::get('/create', [LedgersController::class, 'create'])->name('ledgers.ledger.create');
            Route::get('/show/{ledger}', [LedgersController::class, 'show'])->name('ledgers.ledger.show');
            Route::get('/{ledger}/edit', [LedgersController::class, 'edit'])->name('ledgers.ledger.edit');
            Route::post('/', [LedgersController::class, 'store'])->name('ledgers.ledger.store');
            Route::put('ledger/{ledger}', [LedgersController::class, 'update'])->name('ledgers.ledger.update');
            Route::delete('/ledger/{ledger}', [LedgersController::class, 'destroy'])->name('ledgers.ledger.destroy');
            Route::post('/ledger/{ledger}', [LedgersController::class, 'restore'])->name('ledgers.ledger.restore');
        });


        Route::group(['prefix' => 'branches'], function () {
            Route::get('/', [BranchesController::class, 'index'])->name('branches.branch.index');
            Route::get('/trash', [BranchesController::class, 'trash'])->name('branches.branch.trash');
            Route::get('/create', [BranchesController::class, 'create'])->name('branches.branch.create');
            Route::get('/show/{branch}', [BranchesController::class, 'show'])->name('branches.branch.show')->where('id', '[0-9]+');
            Route::get('/{branch}/edit', [BranchesController::class, 'edit'])->name('branches.branch.edit')->where('id', '[0-9]+');
            Route::post('/', [BranchesController::class, 'store'])->name('branches.branch.store');
            Route::put('branch/{branch}', [BranchesController::class, 'update'])->name('branches.branch.update')->where('id', '[0-9]+');
            Route::delete('/branch/{branch}', [BranchesController::class, 'destroy'])->name('branches.branch.destroy')->where('id', '[0-9]+');
            Route::post('/branch/{branch}', [BranchesController::class, 'restore'])->name('branches.branch.restore')->where('id', '[0-9]+');
        });


        Route::group(['prefix' => 'transactions'], function () {
            Route::get('/', [TransactionsController::class, 'index'])->name('transactions.transaction.index');
            Route::get('/trash', [TransactionsController::class, 'trash'])->name('transactions.transaction.trash');
            Route::get('/create', [TransactionsController::class, 'create'])->name('transactions.transaction.create');
            Route::get('/show/{transaction}', [TransactionsController::class, 'show'])->name('transactions.transaction.show')->where('id', '[0-9]+');
            Route::get('/pdf/{transaction}', [TransactionsController::class, 'getPDF'])->name('transactions.transaction.pdf');
            Route::get('/{transaction}/edit', [TransactionsController::class, 'edit'])->name('transactions.transaction.edit')->where('id', '[0-9]+');
            Route::post('/', [TransactionsController::class, 'store'])->name('transactions.transaction.store');
            Route::put('transaction/{transaction}', [TransactionsController::class, 'update'])->name('transactions.transaction.update')->where('id', '[0-9]+');
            Route::delete('/transaction/{transaction}', [TransactionsController::class, 'destroy'])->name('transactions.transaction.destroy')->where('id', '[0-9]+');
            Route::post('/transaction/{transaction}', [TransactionsController::class, 'restore'])->name('transactions.transaction.restore')->where('id', '[0-9]+');
        });

        Route::group(['prefix' => 'payments'], function () {
            Route::get('/', [PaymentsController::class, 'index'])->name('payments.payment.index');
            Route::get('/trash', [PaymentsController::class, 'trash'])->name('payments.payment.trash');
            Route::get('/create', [PaymentsController::class, 'create'])->name('payments.payment.create');
            Route::get('/show/{transaction}', [PaymentsController::class, 'show'])->name('payments.payment.show')->where('id', '[0-9]+');
            Route::get('/pdf/{transaction}', [PaymentsController::class, 'getPDF'])->name('payments.payment.pdf');
            Route::get('/{transaction}/edit', [PaymentsController::class, 'edit'])->name('payments.payment.edit')->where('id', '[0-9]+');
            Route::post('/', [PaymentsController::class, 'store'])->name('payments.payment.store');
            Route::put('transaction/{transaction}', [PaymentsController::class, 'update'])->name('payments.payment.update')->where('id', '[0-9]+');
            Route::delete('/transaction/{transaction}', [PaymentsController::class, 'destroy'])->name('payments.payment.destroy')->where('id', '[0-9]+');
            Route::post('/transaction/{transaction}', [PaymentsController::class, 'restore'])->name('payments.payment.restore')->where('id', '[0-9]+');
        });


        Route::group(['prefix' => 'journals'], function () {
            Route::get('/', [JournalsController::class, 'index'])->name('journals.journal.index');
            Route::get('/trash', [JournalsController::class, 'trash'])->name('journals.journal.trash');

            Route::get('/create', [JournalsController::class, 'create'])->name('journals.journal.create');
            Route::get('/show/{transaction}', [JournalsController::class, 'show'])->name('journals.journal.show')->where('id', '[0-9]+');
            Route::get('/pdf/{transaction}', [JournalsController::class, 'getPDF'])->name('journals.journal.pdf');
            Route::get('/{transaction}/edit', [JournalsController::class, 'edit'])->name('journals.journal.edit')->where('id', '[0-9]+');
            Route::post('/', [JournalsController::class, 'store'])->name('journals.journal.store');
            Route::put('transaction/{transaction}', [JournalsController::class, 'update'])->name('journals.journal.update')->where('id', '[0-9]+');
            Route::delete('/transaction/{transaction}', [JournalsController::class, 'destroy'])->name('journals.journal.destroy')->where('id', '[0-9]+');
            Route::post('/transaction/{transaction}', [JournalsController::class, 'restore'])->name('journals.journal.restore')->where('id', '[0-9]+');
        });

        Route::group(['prefix' => 'contras'], function () {
            Route::get('/', [ContrasController::class, 'index'])->name('contras.contra.index');
            Route::get('/trash', [ContrasController::class, 'trash'])->name('contras.contra.trash');
            Route::get('/create', [ContrasController::class, 'create'])->name('contras.contra.create');
            Route::get('/show/{transaction}', [ContrasController::class, 'show'])->name('contras.contra.show')->where('id', '[0-9]+');
            Route::get('/pdf/{transaction}', [ContrasController::class, 'getPDF'])->name('contras.contra.pdf');
            Route::get('/{transaction}/edit', [ContrasController::class, 'edit'])->name('contras.contra.edit')->where('id', '[0-9]+');
            Route::post('/', [ContrasController::class, 'store'])->name('contras.contra.store');
            Route::put('transaction/{transaction}', [ContrasController::class, 'update'])->name('contras.contra.update')->where('id', '[0-9]+');
            Route::delete('/transaction/{transaction}', [ContrasController::class, 'destroy'])->name('contras.contra.destroy')->where('id', '[0-9]+');
            Route::post('/transaction/{transaction}', [ContrasController::class, 'restore'])->name('contras.contra.restore')->where('id', '[0-9]+');
        });
        Route::group(['prefix' => 'accounting/reports/trial-balance'], function () {
            Route::get('/', [AccountingReportsController::class, 'trialBalanceFilter'])->name('accounting.report.trial-balance');
            Route::get('/pdf', [AccountingReportsController::class, 'trialBalancePDF'])->name('accounting.report.trial-balance.pdf');
        });
        Route::group(['prefix' => 'accounting/reports/profit-loss'], function () {
            Route::get('/', [AccountingReportsController::class, 'profitLossFilter'])->name('accounting.report.profit-loss');
            Route::get('/pdf', [AccountingReportsController::class, 'profitLossPDF'])->name('accounting.report.profit-loss.pdf');
        });
        Route::group(['prefix' => 'accounting/reports/balance-sheet'], function () {
            Route::get('/', [AccountingReportsController::class, 'balanceSheetFilter'])->name('accounting.report.balance-sheet');
            Route::get('/pdf', [AccountingReportsController::class, 'balanceSheetPDF'])->name('accounting.report.balance-sheet.pdf');
        });

        Route::group(['prefix' => 'accounting/reports/ledger'], function () {
            Route::get('/', [AccountingReportsController::class, 'ledgerFilter'])->name('accounting.report.ledger');
            Route::get('/pdf', [AccountingReportsController::class, 'ledgerPDF'])->name('accounting.report.ledger.pdf');
        });

        Route::group(['prefix' => 'accounting/reports/voucher'], function () {
            Route::get('/', [AccountingReportsController::class, 'voucherFilter'])->name('accounting.report.voucher');
            Route::get('/pdf', [AccountingReportsController::class, 'voucherPDF'])->name('accounting.report.voucher.pdf');
        });

        Route::group(['prefix' => 'accounting/reports/cashbook'], function () {
            Route::get('/', [AccountingReportsController::class, 'cashbookFilter'])->name('accounting.report.cashbook');
            Route::get('/pdf', [AccountingReportsController::class, 'cashbookPDF'])->name('accounting.report.cashbook.pdf');
        });
        Route::group(['prefix' => 'accounting/reports/daybook'], function () {
            Route::get('/', [AccountingReportsController::class, 'daybookFilter'])->name('accounting.report.daybook');
            Route::get('/pdf', [AccountingReportsController::class, 'daybookPDF'])->name('accounting.report.daybook.pdf');
        });
        Route::group(['prefix' => 'accounting/reports/receipt-payment-branch'], function () {
            Route::get('/', [AccountingReportsController::class, 'rpbFilter'])->name('accounting.report.receipt-payment-branch');
            Route::get('/pdf', [AccountingReportsController::class, 'rpbPDF'])->name('accounting.report.receipt-payment-branch.pdf');
        });

        Route::group(['prefix' => 'accounting/settings'], function () {
            Route::get('/', [SettingsController::class, 'edit'])->name('accounting.settings.edit');
            Route::post('/store', [SettingsController::class, 'update'])->name('accounting.settings.update');
        });

    });
