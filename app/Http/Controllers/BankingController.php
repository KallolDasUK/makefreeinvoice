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
        if(isset($request->type) && $request->type == 'deposit'){
            
            $request->validate([
                'account' => 'required',
                'amount' => 'required',
                'date' => 'required']
            );

            $response = $this->save_deposit($request);

        }else if(isset($request->type) && $request->type == 'withdraw'){
            $response = [
                'success' => true,
                'message' => 'This is not functional yet.',
            ];
        }else if(isset($request->type) && $request->type == 'transfer'){

            $response = [
                'success' => true,
                'message' => 'This is not functional yet.',
            ];    
        }else{
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
                // Save transaction details
            $transactionDetail = new TransactionDetail;
            $transactionDetail->transaction_id  = $transaction->id;
            $transactionDetail->ledger_id       = $request->account;
            $transactionDetail->entry_type      = $request->account == $cashAcId ? EntryType::$CR : EntryType::$DR;
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
            $transactionDetail2->ledger_id       = $request->account;
            $transactionDetail2->entry_type      = $request->account == $cashAcId ? EntryType::$DR : EntryType::$CR;
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
