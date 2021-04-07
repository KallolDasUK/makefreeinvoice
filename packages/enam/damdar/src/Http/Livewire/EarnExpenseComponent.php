<?php

namespace Enam\Acc\Http\Livewire;

use Carbon\Carbon;
use Enam\Acc\Models\AccHead;
use Enam\Acc\Models\AccountTransaction;
use Enam\Acc\Utils\DescriptionType;
use Enam\Acc\Utils\HeadType;
use Enam\Acc\Utils\MyApp;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EarnExpenseComponent extends Component
{

    public $message = 'Works';
    public $transactions;
    private $query;
    public $t_income, $t_expense, $income, $expense, $i = [], $e = [];
    public $start, $end;


    public function mount()
    {
        \Illuminate\Support\Facades\View::share('title','Income Statement');
        $start = Carbon::now()->subDays(30)->toDateString();
        $end = Carbon::today()->subDays(0)->toDateString();
        $this->start = $start;
        $this->end = $end;
        $this->filter();

//        dd($this->i,$this->e,$iCount,$eCount);
    }


    public function filter()
    {
        $totalSavings = 0;
        $totalKisitCollection = 0;
        $totalLoan = 0;
        $totalWithdaw = 0;
        $totalDeposit = 0;
        $this->t_income = 0;
        $this->t_expense = 0;
        foreach (AccHead::all() as $head) {
            $query = AccountTransaction::query()->whereBetween('date', [$this->start, $this->end]);
            $debit = $query->whereHead($head->head)->sum('debit');
            $credit = $query->whereHead($head->head)->sum('credit');
            switch ($head->parent_head) {
                case HeadType::$INCOME:
                    $this->i[$head->head] = $credit;
                    break;
                case HeadType::$EXPENSE:
                    $this->e[$head->head] = $debit;
                    break;
                case HeadType::$ASSET:
                    $saving = AccountTransaction::whereHead($head->head)->whereDescription(DescriptionType::$SAVINGS)->sum('credit');
                    $totalSavings += $saving;

                    $kc = AccountTransaction::whereHead($head->head)->whereDescription(DescriptionType::$KISTI_PAID)->sum('credit');
                    $totalKisitCollection += $kc;

                    $got_loan = AccountTransaction::whereHead($head->head)->whereDescription(DescriptionType::$GOT_LOAN)->sum('debit');
                    $totalLoan += $got_loan;

                    $withdraw = AccountTransaction::whereHead($head->head)->whereDescription(DescriptionType::$WITHDRAW)->sum('debit');
                    $totalWithdaw += $withdraw;

                    $deposit = AccountTransaction::whereHead($head->head)->whereDescription(DescriptionType::$DEPOSIT)->sum('credit');
                    $totalDeposit += $deposit;

                    break;
                case HeadType::$LIABILITY:

                    break;
                default:
                    echo $head->parent_head;
                    break;
            }


        }

//        $this->i['সর্বমোট সঞ্চয় বাবদ'] = $totalSavings;
//        $this->i['সর্বমোট জমা বাবদ'] = $totalDeposit;
//        $this->e['সর্বমোট উইথড্রা বাবদ'] = $totalWithdaw;
//        $this->e['লোন বাবদ খরচ'] = $totalLoan;
//        $this->i['কিস্তি সংগ্রহ'] = $totalKisitCollection;
        $iCount = count($this->i);
        $eCount = count($this->e);

        if ($eCount > $iCount) {
            $length = $eCount - $iCount;
            for ($a = 0; $a < $length; $a++) {
                $this->i[str_repeat(" ", $a)] = 0;
            }
        } else {
            $length = $iCount - $eCount;
            for ($a = 0; $a < $length; $a++) {
                $this->e[str_repeat(" ", $a)] = 0;
            }
        }
        krsort($this->i);
        krsort($this->e);
        foreach ($this->i as $key => $value) {
            $this->t_income += $value;
        }
        foreach ($this->e as $key => $value) {
            $this->t_expense += $value;
        }
    }


    public function render()
    {

//        foreach (array_combine([1, 2, 3], ['Kine', 'Joaa', 'Sisir']) as $income => $expense) {
//            echo $income . " " . $expense . "\n";
//        }

//        dd($this->i,$this->e);

        return view('acc::livewire.earn-expense-component')->layout('layouts.admin.base');
    }
}
