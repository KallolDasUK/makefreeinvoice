<?php

namespace Enam\Acc\Http\Livewire;

use Illuminate\Support\Facades\View;
use Livewire\Component;
use Enam\Acc\Models\AccHead;
use Carbon\Carbon;
use Enam\Acc\Utils\MyApp;
use Enam\Acc\Http\Livewire\helpers\VoucherHelper;
use Enam\Acc\Models\AccountTransaction;

class VoucherEntryComponent extends Component
{
    public $heads, $transaction = '', $voucherType, $toast = null;
    public $vno, $cid = 1, $head, $description, $amount = 0, $image, $note, $debit = 0, $credit = 0, $date;
    public $transaction_items = [];

    public function mount()
    {
        View::share('title', 'Voucher Entry');
        $this->heads = AccHead::all();
        $this->vno = random_int(1, 100000);
        $this->date = Carbon::today()->toDateString();
    }

    public function submit()
    {
//        $this->validate([
//            'vno' => 'required'
//        ]);
//        $act = new AccountTransaction;
//        $act->vno = $this->vno;
//        $act->sort_by = $this->cid;
//        $act->head = $this->head;
//        $act->description = $this->description;
//        $act->note = $this->note;
//        $act->date = $this->date;
//        $act->debit = $this->debit;
//        $act->user = auth()->user()->id;
//        $act->credit = $this->credit;
//        $act->save();
//        \session()->flush('message', 'This is a message!');
    }

    public function refreshHeads()
    {
        $this->heads = AccHead::all();
        $this->head = last($this->heads);
    }

    public function updatedAmount()
    {
        $this->toast = null;

        //  dd($this->transaction);

        if ($this->transaction === MyApp::DEBIT) {
            $this->debit = $this->amount;
            $this->credit = 0;
        } elseif ($this->transaction === MyApp::CREDIT) {
            $this->credit = $this->amount;
            $this->debit = 0;
        } else {
            $this->credit = 0;
            $this->debit = 0;
        }

    }

    public function updatedVoucherType()
    {
        $this->toast = null;
        if ($this->voucherType === 'Journal') {
            $this->transaction = '';
            $this->amount = 0;
        } else {
            $this->transaction = $this->voucherType;
        }
        $this->updatedAmount();

    }

    public function updatedTransaction()
    {
        $this->toast = null;

        if ($this->transaction === MyApp::DEBIT) {
            $this->debit = $this->amount;
            $this->credit = 0;
        } elseif ($this->transaction === MyApp::CREDIT) {
            $this->credit = $this->amount;
            $this->debit = 0;
        } else {
            $this->credit = 0;
            $this->debit = 0;
        }
        //dd($this->transaction);
        // dd(['debit' => $this->debit, 'credit' => $this->credit]);
    }


    public function addItem()
    {
        $this->validate([
            'description' => 'required',
            'head' => 'required',
        ]);
        $helper = new VoucherHelper();
        $helper->vno = $this->vno;
        $helper->credit = $this->credit;
        $helper->debit = $this->debit;
        $helper->head = $this->head;
        $helper->description = $this->description;
        $helper->user = auth()->user()->id;
        $helper->note = $this->note;
        $helper->date = $this->date;
        $helper->voucherType = $this->voucherType;
        array_push($this->transaction_items, (array)$helper);
        $this->resetForm();
//        dd($this->transaction_items);
    }


    public function resetForm()
    {
        $this->voucherType = '';
        $this->head = '';
        $this->description = '';
        $this->note = '';
    }

    public function processToDatabase()
    {
//        dd('Process');
        foreach ($this->transaction_items as $i) {
            if ($i['voucherType'] === MyApp::JOURNAL) {
                $t1 = new AccountTransaction;
                $t1->sort_by = $i['sort_by'];
                $t1->vno = $i['vno'];
                $t1->head = $i['head'];
                $t1->description = $i['description'];
                $t1->note = $i['note'];
                $t1->user = $i['user'];

                if ($i['credit'] > $i['debit']) {
                    $t1->credit = $i['credit'];
                } else {
                    $t1->debit = $i['debit'];
                }
                $t1->date = $i['date'];
                $t1->save();
            } else {
                if ($i['voucherType'] === MyApp::CREDIT) {
                    $t1 = new AccountTransaction;
                    $t1->sort_by = $i['sort_by'];
                    $t1->vno = $i['vno'];
                    $t1->head = $i['head'];
                    $t1->description = $i['description'];
                    $t1->note = $i['note'];
                    $t1->user = $i['user'];
                    $t1->debit = $i['credit'];
                    $t1->date = $i['date'];
                    $t1->save();
                    $t1 = new AccountTransaction;
                    $t1->sort_by = $i['sort_by'];
                    $t1->vno = $i['vno'];
                    $t1->head = 'Cash';
                    $t1->description = $i['description'];
                    $t1->note = $i['note'];
                    $t1->user = $i['user'];

                    $t1->credit = $i['credit'];
                    $t1->date = $i['date'];
                    $t1->save();
                } else {
                    $t1 = new AccountTransaction;
                    $t1->sort_by = $i['sort_by'];
                    $t1->vno = $i['vno'];
                    $t1->head = $i['head'];
                    $t1->description = $i['description'];
                    $t1->note = $i['note'];
                    $t1->user = $i['user'];

                    $t1->credit = $i['debit'];
                    $t1->date = $i['date'];
                    $t1->save();
                    $t1 = new AccountTransaction;
                    $t1->sort_by = $i['sort_by'];
                    $t1->vno = $i['vno'];
                    $t1->head = 'Cash';
                    $t1->description = $i['description'];
                    $t1->note = $i['note'];
                    $t1->user = $i['user'];

                    $t1->debit = $i['debit'];
                    $t1->date = $i['date'];
                    $t1->save();
                }


            }
        }
        $this->toast = 'Voucher Added Successfully';
        $this->transaction_items = [];

    }

    public function render()
    {

        return view('acc::livewire.voucher-entry-component')->layout('layouts.admin.base');
    }
}
