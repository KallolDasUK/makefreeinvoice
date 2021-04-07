<?php

namespace Enam\Acc\Http\Livewire;


use Enam\Acc\Models\AccHead;
use Enam\Acc\Models\AccountTransaction;
use Illuminate\Support\Facades\View;
use Livewire\Component;

class LedgerComponent extends Component
{

    public $startDate, $endDate, $previousBalance = 0, $selectedHead = "Choose your option";
    public $reports = [];
    public $heads = [];
    public $title = 'Ledger Report';

    function mount()
    {
        View::share('title', 'Ledger Report');
        $this->heads = AccHead::all();
    }

    public function submit(): void
    {
        if ($this->selectedHead === 'Choose your option') {
            $this->addError('selectedHead','Select Your Head First');
            return;
        }

        $this->validate([
            'startDate' => 'required',
            'endDate' => 'required',
            'selectedHead' => 'required',
        ]);


        $this->previousBalance = AccountTransaction::query()->where('head', $this->selectedHead)->whereDate('date', '<', $this->startDate)->sum('debit') - AccountTransaction::query()->where('head', $this->selectedHead)->whereDate('date', '<', $this->startDate)->sum('credit');
        $this->reports = AccountTransaction::query()->where('head', $this->selectedHead)->whereDate('date', '>=', $this->startDate)->whereDate('date', '<=', $this->endDate)->get()->toArray();


    }

    public function render()
    {
        return view('acc::livewire.ledger-component', ['title' => 'Test works'])->layout('layouts.admin.base');
    }
}
