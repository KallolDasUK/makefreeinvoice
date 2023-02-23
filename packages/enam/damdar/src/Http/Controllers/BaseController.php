<?php

namespace Enam\Acc\Http\Controllers;


use App\AccTransaction;
use App\Models\Invoice;
use Carbon\Carbon;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Utils\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BaseController extends Controller
{

    public function index(Request $request)
    {


        $date = $request->date ?? today()->toDateString();
        $date = Carbon::parse($date);
        View::share('title', 'Overview');
        $user = auth()->user();
        $payment = Transaction::query()->where('txn_type', VoucherType::$PAYMENT)->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
        $receive = Transaction::query()->where('txn_type', VoucherType::$RECEIVE)->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
        $journal = Transaction::query()->where('txn_type', VoucherType::$JOURNAL)->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
        $contra = Transaction::query()->where('txn_type', VoucherType::$CONTRA)->whereMonth('date', $date->month)->whereYear('date', $date->year)->sum('amount');
        $date = $date->format('Y-m');
        $has_invoice = \App\Models\Invoice::query()->exists();
        $shortcuts = \App\Models\Shortcut::all();

        return \view('acc::index', compact('date', 'payment', 'receive', 'journal', 'contra', 'has_invoice', 'shortcuts'));
    }

    public $data = [];

    public function coa()
    {
        View::share('title', 'Chart of Accounts');


        $ledger_groups = LedgerGroup::all();
        $ledger = Ledger::all();
        $data = [];
        foreach (['Asset', 'Liabilities', 'Income', 'Expense'] as $acc) {

            $groups = LedgerGroup::query()->where('nature', $acc)->get();
            $nodes = [];
            foreach ($groups as $group) {
                $nodes[] = ['text' => $group->group_name, 'nodes' => $this->getNode($group->id)];
            }
            $data[] = ['text' => $acc, 'nodes' => $nodes];
        }

        return view('acc::others.coa', compact('data'));
    }


}
