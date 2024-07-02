<?php

namespace Enam\Acc\Http\Controllers;


use App\AccTransaction;
use App\Models\Invoice;
use Carbon\Carbon;
use App\Models\Bill;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Utils\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Enam\Acc\Utils\LedgerHelper;
use Enam\Acc\Models\GroupMap;

class BaseController extends Controller
{

    public function index(Request $request)
    {

//        dd(\auth()->user(), 'bal');

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

        $cashAcId = optional(GroupMap::query()->firstWhere('key', LedgerHelper::$CASH_AC))->value;        
        // Fetch the ledger accounts whose group is "Bank Accounts" or whose ID is the Cash A/C
        $depositAccounts = Ledger::whereIn('ledger_group_id', LedgerGroup::where('group_name', 'Bank Accounts')->pluck('id'))
                             ->orWhere('id', $cashAcId)
                             ->get()
                             ->sortBy('ledger_name');


        return \view('acc::index', compact('date', 'payment', 'receive', 'journal', 'contra', 'has_invoice', 'shortcuts', 'cashAcId', 'depositAccounts'));
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
