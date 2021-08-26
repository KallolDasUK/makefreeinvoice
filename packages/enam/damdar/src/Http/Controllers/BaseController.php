<?php

namespace Enam\Acc\Http\Controllers;


use App\AccTransaction;
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
        $intent = auth()->user()->createSetupIntent();
        $invoices = auth()->user()->invoices();
        $upcoming_invoice = auth()->user()->upcomingInvoice();

        $key = \config('services.stripe.secret');
        $stripe = new \Stripe\StripeClient($key);
        $currentPlan = null;
        $price = null;
        if ($user->subscribed('default')) {
            $subscription = $user->subscriptions->first();
            $sub_stripe_id = $subscription->stripe_id;
            $sub = $stripe->subscriptions->retrieve($sub_stripe_id);
            $sub->product = $stripe->products->retrieve(
                $sub->plan->product, []
            );
            $currentPlan = $sub;
//            dd($sub->toArray());

        }
        return \view('acc::index', compact('date', 'payment','currentPlan', 'receive', 'journal', 'contra', 'intent', 'invoices', 'upcoming_invoice'));
    }

    public $data = [];

    public function coa()
    {
        View::share('title', 'Chart of Accounts');

        $data = [];

        $ledger_groups = LedgerGroup::all();
        $ledger = Ledger::all();
        foreach (['Asset', 'Liabilities', 'Income', 'Expense'] as $acc) {

            $groups = LedgerGroup::query()->where('nature', $acc)->get();
            $nodes = [];
            foreach ($groups as $group) {
                $nodes[] = ['text' => $group->group_name, 'nodes' => $this->getNode($group->id)];
            }
            $data[] = ['text' => $acc, 'nodes' => $nodes];
//            if (empty($data[1]['nodes'])) {
//                unset($data[1]['nodes']);
//            }

        }
//        dd($data);
//        dd(json_encode($data));
//        return json_encode($data);
        return view('acc::others.coa', compact('data'));
    }

    public function getNode($group_id)
    {
        $g = LedgerGroup::find($group_id);

        $groups = LedgerGroup::query()->where('parent', $group_id)->get();
        $ledger = Ledger::query()->where('ledger_group_id', $g->id)->get()->map(function ($ledger) {
            return ['text' => $ledger->ledger_name, 'href' => route('ledgers.ledger.edit', $ledger->id)];
        })->toArray();
        $nodes = $ledger;

        foreach ($groups as $group) {
            $ledger = Ledger::query()->where('ledger_group_id', $group->id)->get()->map(function ($ledger) {
                return ['text' => $ledger->ledger_name, 'href' => route('ledgers.ledger.edit', $ledger->id)];
            })->toArray();
            $nodes[] = ['text' => $group->group_name, 'nodes' => $ledger + $this->getNode($group->id)];
        }
        return $nodes;
    }


}
