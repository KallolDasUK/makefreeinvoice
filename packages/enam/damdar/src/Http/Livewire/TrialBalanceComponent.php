<?php

namespace Enam\Acc\Http\Livewire;

use Enam\Acc\Models\AccHead;
use Enam\Acc\Models\AccountTransaction;
use Illuminate\Support\Facades\View;
use Livewire\Component;

class TrialBalanceComponent extends Component
{
    public $startDate, $endDate;
    public $trails = [];

    public function mount()
    {
        View::share('title', 'Trial Balance');

        foreach (AccHead::all() as $head) {
            $ts = AccountTransaction::query()->where('head', $head->head)->get();
            $debit = 0;
            $credit = 0;
            $bal = 0;
            foreach ($ts as $t) {
                $debit += $t->debit;
                $credit += $t->credit;
            }
            $bal = $debit - $credit;
            $this->trails[] = ['head' => $head->head, 'credit' => $credit, 'debit' => $debit, 'bal' => $bal];
        }
    }
    public function submit(): void
    {
        $this->validate([
            'startDate' => 'required',
            'endDate' => 'required'
        ]);


    }


    public function render()
    {

        return view('acc::livewire.trial-balance-component')->layout('layouts.admin.base');
    }
}
