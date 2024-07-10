<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Utils\LedgerHelper;
use Enam\Acc\Utils\EntryType;

use App\Models\BankTransaction;

class BankingController extends Controller
{
    use TransactionTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::info('Request Data:', $request->all());

        if (isset($request->type) && $request->type == 'deposit') {
            $request->validate([
                'account' => 'required',
                'amount' => 'required',
                'date' => 'required'
            ]);

            $response = $this->save_deposit($request);
        } else if (isset($request->type) && $request->type == 'withdraw') {
            $request->validate([
                'deposit_to' => 'required',
                'withdraw_amount' => 'required',
                'withdraw_date' => 'required'
            ]);

            $response = $this->save_withdraw($request);
        } else if (isset($request->type) && $request->type == 'transfer') {
            $request->validate([
                'deposit_to' => 'required',
                'account_to' => 'required',
                'amount' => 'required',
                'transfer_date' => 'required'
            ]);
            $response = $this->save_transfer($request);
        } else {
            $response = [
                'success' => false,
                'message' => 'Something went wrong.',
            ];
        }
        return response()->json($response);
    }


    public function save_deposit($request)
    {
        DB::beginTransaction();
    
        try {
            // Save the bank transaction
            $bankTransaction = new BankTransaction;
            $bankTransaction->ledger_id = $request->account;
            $bankTransaction->entry_type = EntryType::$DR;
            $bankTransaction->txn_type = LedgerHelper::$BANK_DEPOSIT;
            $bankTransaction->Note = $request->note;
            $bankTransaction->amount = $request->amount;
            $bankTransaction->user_id = auth()->id();
            $bankTransaction->client_id = auth()->user()->client_id;
            $bankTransaction->date = $request->date;
    
            if (!$bankTransaction->save()) {
                throw new \Exception('Failed to record bank transaction.');
            }
    
            // Get ledger name
            $ledger = Ledger::find($request->account);
            if (!$ledger) {
                throw new \Exception('Invalid ledger account.');
            }
    
            // Save the transaction            
            $transaction = new Transaction;
            $transaction->ledger_name =  $ledger->ledger_name;
            $transaction->amount = $request->amount;
            $transaction->txn_type = LedgerHelper::$BANK_DEPOSIT;
            $transaction->type = BankTransaction::class;
            $transaction->type_id = $bankTransaction->id;
            $transaction->user_id = auth()->id();
            $transaction->client_id = auth()->user()->client_id;
            $transaction->note = $request->note;
            $transaction->date =  now();
            $transaction->voucher_no = $this->getVoucherID();
    
            if (!$transaction->save()) {
                throw new \Exception('Failed to record transaction.');
            }
    
            $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
    
            // First transaction detail entry
            $transactionDetail = new TransactionDetail;
            $transactionDetail->transaction_id  = $transaction->id;
            $transactionDetail->ledger_id       = $request->account;
            $transactionDetail->entry_type      = EntryType::$DR;
            $transactionDetail->amount          = $request->amount;
            $transactionDetail->note            = $request->note;
            $transactionDetail->date            = now();
            $transactionDetail->type            = BankTransaction::class;
            $transactionDetail->type_id         = $bankTransaction->id;
            $transactionDetail->is_bank         = 1;
    
            if (!$transactionDetail->save()) {
                throw new \Exception('Failed to record transaction during first entry.');
            }
    
            // Second transaction detail entry
            $transactionDetail2 = new TransactionDetail;
            $transactionDetail2->transaction_id  = $transaction->id;
            $transactionDetail2->ledger_id       = $cashAcId ;
            $transactionDetail2->entry_type      =  EntryType::$CR ;
            $transactionDetail2->amount          = $request->amount;
            $transactionDetail2->note            = $request->note;
            $transactionDetail2->date            = now();
            $transactionDetail2->type            = BankTransaction::class;
            $transactionDetail2->type_id         = $bankTransaction->id;
            $transactionDetail2->is_bank         = 1;
    
            if (!$transactionDetail2->save()) {
                throw new \Exception('Failed to record transaction during second entry.');
            }
    
            DB::commit();
    
            $response = [
                'success' => true,
                'message' => 'Data stored successfully.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
    
            Log::error('Error while saving deposit: ' . $e->getMessage());
    
            $response = [
                'success' => false,
                'message' => 'Error while saving. Please try again later.'
            ];
        }
    
        return $response;
    }
    

    public function save_withdraw($request)
    {
        DB::beginTransaction();

        try {
            // Save the bank transaction
            $bankTransaction = new BankTransaction;
            $bankTransaction->ledger_id = $request->deposit_to;
            $bankTransaction->entry_type = EntryType::$CR;
            $bankTransaction->txn_type = LedgerHelper::$BANK_WITHDRAW;
            $bankTransaction->Note = $request->withdraw_note;
            $bankTransaction->amount = $request->withdraw_amount;
            $bankTransaction->user_id = auth()->id();
            $bankTransaction->client_id = auth()->user()->client_id;
            $bankTransaction->date = $request->withdraw_date;


            if (!$bankTransaction->save()) {
                throw new \Exception('Failed to record bank transaction.');
            }

            // Get ledger name
            $ledger = Ledger::find($request->deposit_to);
            if (!$ledger) {
                throw new \Exception('Invalid ledger account.');
            }

            // Save the transaction            
            $transaction = new Transaction;
            $transaction->ledger_name = $ledger->ledger_name;
            $transaction->amount = $request->withdraw_amount;
            $transaction->txn_type = LedgerHelper::$BANK_WITHDRAW;
            $transaction->type = BankTransaction::class;
            $transaction->type_id = $bankTransaction->id;
            $transaction->user_id = auth()->id();
            $transaction->client_id = auth()->user()->client_id;
            $transaction->note = $request->withdraw_note;
            $transaction->date = now();
            $transaction->voucher_no = $this->getVoucherID();


            if (!$transaction->save()) {
                throw new \Exception('Failed to record transaction.');
            }

            $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;

            // First transaction detail entry
            $transactionDetail = new TransactionDetail;
            $transactionDetail->transaction_id = $transaction->id;
            $transactionDetail->ledger_id = $request->deposit_to;
            $transactionDetail->entry_type =  EntryType::$CR ;
            $transactionDetail->amount = $request->withdraw_amount;
            $transactionDetail->note = $request->withdraw_note;
            $transactionDetail->date = now();
            $transactionDetail->type = BankTransaction::class;
            $transactionDetail->type_id = $bankTransaction->id;
            $transactionDetail->is_bank = 1;


            if (!$transactionDetail->save()) {
                throw new \Exception('Failed to record transaction during first entry.');
            }

            // Second transaction detail entry
            $transactionDetail2 = new TransactionDetail;
            $transactionDetail2->transaction_id = $transaction->id;
            $transactionDetail2->ledger_id = $cashAcId ;
            $transactionDetail2->entry_type =  EntryType::$DR;
            $transactionDetail2->amount = $request->withdraw_amount;
            $transactionDetail2->note = $request->withdraw_note;
            $transactionDetail2->date = now();
            $transactionDetail2->type = BankTransaction::class;
            $transactionDetail2->type_id = $bankTransaction->id;
            $transactionDetail2->is_bank = 1;


            if (!$transactionDetail2->save()) {
                throw new \Exception('Failed to record transaction during second entry.');
            }

            DB::commit();

            $response = [
                'success' => true,
                'message' => 'Data stored successfully.'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving withdraw: ' . $e->getMessage());

            $response = [
                'success' => false,
                'message' => 'Error while saving. Please try again later.'
            ];
        }

        return $response;
    }

    public function save_transfer($request)
    {
        DB::beginTransaction();
    
        try {
            // Save the bank transaction for the account to transfer from
            $bankTransactionFrom = new BankTransaction;
            $bankTransactionFrom->ledger_id = $request->account_to;
            $bankTransactionFrom->entry_type = EntryType::$CR;
            $bankTransactionFrom->txn_type = LedgerHelper::$BANK_TRANSFER;
            $bankTransactionFrom->Note = $request->note;
            $bankTransactionFrom->amount = $request->amount;
            $bankTransactionFrom->user_id = auth()->id();
            $bankTransactionFrom->client_id = auth()->user()->client_id;
            $bankTransactionFrom->date = $request->transfer_date;
    
    
            if (!$bankTransactionFrom->save()) {
                throw new \Exception('Failed to record bank transaction (From).');
            }
    
            // Save the bank transaction for the account to transfer to
            $bankTransactionTo = new BankTransaction;
            $bankTransactionTo->ledger_id = $request->deposit_to;
            $bankTransactionTo->entry_type = EntryType::$DR;
            $bankTransactionTo->txn_type = LedgerHelper::$BANK_TRANSFER;
            $bankTransactionTo->Note = $request->note;
            $bankTransactionTo->amount = $request->amount;
            $bankTransactionTo->user_id = auth()->id();
            $bankTransactionTo->client_id = auth()->user()->client_id;
            $bankTransactionTo->date = $request->transfer_date;
    
    
            if (!$bankTransactionTo->save()) {
                throw new \Exception('Failed to record bank transaction (To).');
            }
    
            // Get ledger names
            $ledgerFrom = Ledger::find($request->account_to);
            if (!$ledgerFrom) {
                throw new \Exception('Invalid ledger account (From).');
            }
    
            $ledgerTo = Ledger::find($request->deposit_to);
            if (!$ledgerTo) {
                throw new \Exception('Invalid ledger account (To).');
            }
    
            // Save the transaction for the account transferring from
            $transactionFrom = new Transaction;
            $transactionFrom->ledger_name = $ledgerFrom->ledger_name;
            $transactionFrom->amount = $request->amount;
            $transactionFrom->txn_type = LedgerHelper::$BANK_TRANSFER;
            $transactionFrom->type = BankTransaction::class;
            $transactionFrom->type_id = $bankTransactionFrom->id;
            $transactionFrom->user_id = auth()->id();
            $transactionFrom->client_id = auth()->user()->client_id;
            $transactionFrom->note = $request->note;
            $transactionFrom->date = now();
            $transactionFrom->voucher_no = $this->getVoucherID();
    
    
            if (!$transactionFrom->save()) {
                throw new \Exception('Failed to record transaction (From).');
            }
    
            // Save the transaction for the account transferring to
            $transactionTo = new Transaction;
            $transactionTo->ledger_name = $ledgerTo->ledger_name;
            $transactionTo->amount = $request->amount;
            $transactionTo->txn_type = LedgerHelper::$BANK_TRANSFER;
            $transactionTo->type = BankTransaction::class;
            $transactionTo->type_id = $bankTransactionTo->id;
            $transactionTo->user_id = auth()->id();
            $transactionTo->client_id = auth()->user()->client_id;
            $transactionTo->note = $request->note;
            $transactionTo->date = now();
            $transactionTo->voucher_no = $this->getVoucherID();
    
    
            if (!$transactionTo->save()) {
                throw new \Exception('Failed to record transaction (To).');
            }
    
            // $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;
    
            // First transaction detail entry for account to transfer from
            $transactionDetailFrom = new TransactionDetail;
            $transactionDetailFrom->transaction_id = $transactionFrom->id;
            $transactionDetailFrom->ledger_id = $request->account_to;
            $transactionDetailFrom->entry_type = EntryType::$CR;
            $transactionDetailFrom->amount = $request->amount;
            $transactionDetailFrom->note = $request->note;
            $transactionDetailFrom->date = now();
            $transactionDetailFrom->type = BankTransaction::class;
            $transactionDetailFrom->type_id = $bankTransactionFrom->id;
            $transactionDetailFrom->is_bank = 1;
    
    
            if (!$transactionDetailFrom->save()) {
                throw new \Exception('Failed to record transaction detail (From).');
            }
    
            // First transaction detail entry for account to transfer to
            $transactionDetailTo = new TransactionDetail;
            $transactionDetailTo->transaction_id = $transactionTo->id;
            $transactionDetailTo->ledger_id = $request->deposit_to;
            $transactionDetailTo->entry_type = EntryType::$DR;
            $transactionDetailTo->amount = $request->amount;
            $transactionDetailTo->note = $request->note;
            $transactionDetailTo->date = now();
            $transactionDetailTo->type = BankTransaction::class;
            $transactionDetailTo->type_id = $bankTransactionTo->id;
            $transactionDetailTo->is_bank = 1;
    
    
            if (!$transactionDetailTo->save()) {
                throw new \Exception('Failed to record transaction detail (To).');
            }
    
            DB::commit();
            
            $response = [
                'success' => true,
                'message' => 'Data stored successfully.'
            ];
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving transfer: ' . $e->getMessage());
    
            $response = [
                'success' => false,
                'message' => 'Error while saving. Please try again later.'
            ];
        }
    
        return $response;
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
