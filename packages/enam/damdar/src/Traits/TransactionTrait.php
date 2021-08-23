<?php


namespace Enam\Acc\Traits;


use Carbon\Carbon;
use Enam\Acc\Models\Branch;
use Enam\Acc\Utils\EntryType;
use \PDF;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\LedgerHelper;
use Enam\Acc\Utils\Nature;
use Enam\Acc\Utils\VoucherType;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\This;

trait TransactionTrait
{
    public $arr = [];

    public function getChildLedgerGroup($id)
    {
        $groups = LedgerGroup::query()->where('parent', $id)->get();
        $ledger = Ledger::query()->where('ledger_group_id', $id);
//        dd($groups, $ledger->get());
        $ledger_id = $ledger->pluck('id')->toArray();
        foreach ($ledger_id as $id) {
            array_push($this->arr, $id);
        }

//        dd(self::$arr);
//        dd(self::$arr);

        foreach ($groups as $group) {
            $this->getChildLedgerGroup($group->id);
        }

    }

    public function getBankLedgers()
    {
        try {
            $ledgerMap = GroupMap::query()->where('key', LedgerHelper::$BANK_ACCOUNTS)->first()->value ?? -1;
            $parentBankLedger = LedgerGroup::query()->where('id', $ledgerMap)->first();
            $this->getChildLedgerGroup($parentBankLedger->id);

            return $this->arr;

        } catch (\Exception $exception) {
            dd($exception);
            return [];
        }


    }

    public function getIncomeLedgers()
    {
        $this->arr = [];

        $incomeLedgerGroups = LedgerGroup::query()->where('nature', Nature::$Income)->get();

        foreach ($incomeLedgerGroups as $group) {
            try {
                $parentBankLedger = LedgerGroup::query()->where('id', $group->id)->first();
                $this->getChildLedgerGroup($parentBankLedger->id);

            } catch (\Exception $exception) {
                dd($exception);
                return [];
            }
        }
        return $this->arr;

    }

    public function getExpenseLedgers()
    {
        $this->arr = [];

        $incomeLedgerGroups = LedgerGroup::query()->where('nature', Nature::$EXPENSE)->get();

        foreach ($incomeLedgerGroups as $group) {
            try {
                $parentBankLedger = LedgerGroup::query()->where('id', $group->id)->first();
                $this->getChildLedgerGroup($parentBankLedger->id);

            } catch (\Exception $exception) {
                dd($exception);
                return [];
            }
        }
        return $this->arr;

    }

    public function getAssetLedgers()
    {
        $this->arr = [];

        $incomeLedgerGroups = LedgerGroup::query()->where('nature', Nature::$ASSET)->get();

        foreach ($incomeLedgerGroups as $group) {
            try {
                $parentBankLedger = LedgerGroup::query()->where('id', $group->id)->first();
                $this->getChildLedgerGroup($parentBankLedger->id);

            } catch (\Exception $exception) {
                dd($exception);
                return [];
            }
        }
        return $this->arr;

    }

    public function getLiabilitiesLedgers()
    {
        $this->arr = [];

        $incomeLedgerGroups = LedgerGroup::query()->where('nature', Nature::$LIABILITIES)->get();

        foreach ($incomeLedgerGroups as $group) {
            try {
                $parentBankLedger = LedgerGroup::query()->where('id', $group->id)->first();
                $this->getChildLedgerGroup($parentBankLedger->id);

            } catch (\Exception $exception) {
                dd($exception);
                return [];
            }
        }
        return $this->arr;

    }


    public function getVoucherID($type = "VN")
    {
        if ($type == "VN") {
            $totalAcc = Transaction::withTrashed()->where('voucher_no', 'like', '%VN%')->count();
        } else {
            $totalAcc = Transaction::withTrashed()->where('txn_type', $type)->count();
        }
        $voucher_id = str_pad(++$totalAcc, 8, '0', STR_PAD_LEFT);
//        dd($v);
//        dd($totalAcc);
        $voucher = "";
        $prefix = $type;
        if ($type == VoucherType::$RECEIVE) {
            $prefix = "RV";
        } elseif ($type == VoucherType::$PAYMENT) {
            $prefix = "PV";
        } elseif ($type == VoucherType::$JOURNAL) {
            $prefix = "JV";
        } elseif ($type == VoucherType::$CONTRA) {
            $prefix = "CV";
        }
        $voucher = $prefix . '-' . $voucher_id;
        return $voucher;
    }

    public function getTrialBalanceReport(Request $request)
    {
        $branch_id = $request->branch_id;
        $start = $request->start_date;
        $end = $request->end_date;

        $ledgersWithFirstParent = [];
        $ledgers = Ledger::withTransactions($start, $end, $branch_id);

        $income = 0;
        $expense = 0;
        foreach ($ledgers as $ledger) {
            $group = $ledger->ledgerGroup->group_name ?? 'Others';

//            dd($this->getRootParent($ledger));
            $nature = $this->getRootParent($ledger)->nature;
            if ($nature === 'Asset' || $nature === 'Income') {
                $income += $ledger->total_debit;
            } else {
                $expense += $ledger->total_debit;

            }
            $ledgersWithFirstParent[$group][] = $ledger;
        }

        return array($ledgersWithFirstParent);


    }


    public function getProfitLossReport(Request $request)
    {
        $branch_id = $request->branch_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        /* Income Query */
        $incomeLedgers = [];
        $totalIncome = 0;
        $income_ids = $this->getIncomeLedgers();
        foreach ($income_ids as $ledger_id) {
            $ledger = Ledger::find($ledger_id);
            if (is_null($ledger)) continue;
            $amount = TransactionDetail::query()->when($branch_id != 'All', function ($query) use ($branch_id) {
                return $query->where('branch_id', $branch_id);
            })->whereBetween('date', [$start_date, $end_date])->where('ledger_id', $ledger_id)->sum('amount');
            if (!$amount) continue;

            $incomeLedgers[$ledger->ledgerGroup->group_name][] = ['ledger_name' => $ledger->ledger_name, 'amount' => $amount];
            $totalIncome += $amount;
        }

        /* Expense Query */

        $expenseLedgers = [];
        $totalExpense = 0;

        $expense_ids = $this->getExpenseLedgers();
        foreach ($expense_ids as $ledger_id) {
            $ledger = Ledger::find($ledger_id);
            if (is_null($ledger)) continue;
            $amount = TransactionDetail::query()->when($branch_id != 'All', function ($query) use ($branch_id) {
                return $query->where('branch_id', $branch_id);
            })->whereBetween('date', [$start_date, $end_date])->where('ledger_id', $ledger_id)->sum('amount');
            if (!$amount) continue;

            $expenseLedgers[$ledger->ledgerGroup->group_name][] = ['ledger_name' => $ledger->ledger_name, 'amount' => $amount];
            $totalExpense += $amount;

        }


//        dd($incomeLedgers, $expenseLedgers);

        $branch_name = optional(Branch::find($request->branch_id))->name ?? 'All';
        $data = ['expenseLedgers' => $expenseLedgers, 'incomeLedgers' => $incomeLedgers,
            'start_date' => $request->start_date, 'end_date' => $request->end_date, 'branch_name' => $branch_name,
            'totalIncome' => $totalIncome, 'totalExpense' => $totalExpense];
        return $data;

    }

    public function getBalanceSheetReport(Request $request)
    {
        $branch_id = $request->branch_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        /* Income Query */
        $assetLedgers = [];
        $totalAsset = 0;
        $asset_ids = $this->getAssetLedgers();
        foreach ($asset_ids as $ledger_id) {
            $ledger = Ledger::find($ledger_id);
            if (is_null($ledger)) continue;
            $data = $this->getLedgerReport($branch_id, $ledger_id, $start_date, $end_date);
            $amount = $data['closing_debit'] == 0 ? -$data['closing_credit'] : $data['closing_debit'];
//            dump($data['ledger_name']);
            if ($data['ledger_name'] == 'Cash A/C') {
//                dd($data,$amount);

            }
            if ($amount == 0) {
                continue;
            }

            $group = $this->getSecondRootParent($ledger);
            $assetLedgers[$group->group_name][] = ['ledger_name' => $ledger->ledger_name, 'amount' => $amount];
            $totalAsset += $amount;
        }


        /* Expense Query */

        $liabilitiesLedger = [];
        $totalLiability = 0;

        $liablities_ids = $this->getLiabilitiesLedgers();
        foreach ($liablities_ids as $ledger_id) {
            $ledger = Ledger::find($ledger_id);
            if (is_null($ledger)) continue;
            $data = $this->getLedgerReport($branch_id, $ledger_id, $start_date, $end_date);
            $amount = $data['closing_credit'] == 0 ? -$data['closing_debit'] : $data['closing_credit'];

            if ($amount == 0) {
                continue;
            }
            $group = $this->getSecondRootParent($ledger);
            $liabilitiesLedger[$group->group_name][] = ['ledger_name' => $ledger->ledger_name, 'amount' => $amount];
            $totalLiability += $amount;

        }

        $profitLoss = $this->getProfitLossReport($request);
        $profit = $profitLoss['totalIncome'] - $profitLoss['totalExpense'];

        $branch_name = optional(Branch::find($request->branch_id))->name ?? 'All';
        $data = ['assetLedgers' => $assetLedgers, 'liabilitiesLedgers' => $liabilitiesLedger, 'start_date' => $request->start_date, 'end_date' => $request->end_date,
            'branch_name' => $branch_name, 'totalAsset' => $totalAsset, 'totalLiability' => $totalLiability, 'profit' => $profit];

        return $data;


    }


    public function getLedgerReport($branch_id, $ledger_id, $start_date, $end_date)

    {


        $branch_name = optional(Branch::find($branch_id))->name;
        $ledger = Ledger::findOrFail($ledger_id);
        $ledger_name = $ledger->ledger_name;
        $transaction_details = TransactionDetail::query()
            ->where('ledger_id', $ledger->id)
            ->where('note', '!=', "OpeningBalance")
            ->when($branch_id != 'All', function ($query) use ($branch_id) {
                return $query->where('branch_id', $branch_id);
            })
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date')->orderBy('voucher_no')->get();
//        dd($transaction_details);

        $openingDebit = (int)TransactionDetail::query()
            ->where('ledger_id', $ledger->id)
            ->where('entry_type', EntryType::$DR)
            ->where('note', '!=', EntryType::$OPENING_BALANCE)
            ->where('date', '<', $start_date)
            ->sum('amount');


        $openingCredit = (int)TransactionDetail::query()
            ->where('ledger_id', $ledger->id)
            ->where('entry_type', EntryType::$CR)
            ->where('note', '!=', EntryType::$OPENING_BALANCE)
            ->where('date', '<', $start_date)
            ->sum('amount');


//        dd($openingDebit, $openingCredit);
        if ($ledger->opening) {
            if ($ledger->opening_type == EntryType::$DR) {
                $openingDebit += $ledger->opening;
            } else {
                $openingCredit += $ledger->opening;
            }
        }

        if ($openingDebit > $openingCredit) {
            $openingDebit = $openingDebit - $openingCredit;
            $openingCredit = 0;
        } else {
            $openingCredit = $openingCredit - $openingDebit;
            $openingDebit = 0;
        }

        $TrDebit = $transaction_details->where('entry_type', EntryType::$DR)->sum('amount');
        $TrCredit = $transaction_details->where('entry_type', EntryType::$CR)->sum('amount');

        $closingDebit = $openingDebit + $TrDebit;
        $closingCredit = $openingCredit + $TrCredit;

        if ($closingDebit > $closingCredit) {
            $closingDebit = $closingDebit - $closingCredit;
            $closingCredit = 0;
        } else {
            $closingCredit = $closingCredit - $closingDebit;
            $closingDebit = 0;
        }

        $ledgerTransactions = $transaction_details;
        $data = ['start_date' => $start_date, 'end_date' => $end_date, 'branch_name' => $branch_name,
            'ledger_name' => $ledger_name, 'ledger' => $ledger, 'ledgerTransactions' => $ledgerTransactions,
            'opening_credit' => $openingCredit, 'opening_debit' => $openingDebit,
            'closing_credit' => $closingCredit, 'closing_debit' => $closingDebit
        ];
        return $data;

    }


    public function getVoucherReport(Request $request)
    {
        $branch_id = $request->branch_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $branch_name = optional(Branch::find($branch_id))->name ?? 'All';


        $txns = Transaction::query()->when($branch_id != 'All', function ($query) use ($branch_id) {
            return $query->where('branch_id', $branch_id);
        })
            ->where('txn_type', $request->voucher_type)
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date')
            ->get();


        $data = ['start_date' => $start_date, 'end_date' => $end_date, 'branch_name' => $branch_name,
            'voucher_type' => $request->voucher_type,
            'txns' => $txns
        ];
        return $data;

    }


    public function getCashBookReport(Request $request)
    {
        $branch_id = $request->branch_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $branch_name = optional(Branch::find($branch_id))->name ?? 'All';

        $cashAc = optional(GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first())->value;
        $txn_details = TransactionDetail::query()->when($branch_id != 'All', function ($query) use ($branch_id) {
            return $query->where('branch_id', $branch_id);
        })
            ->where('ledger_id', $cashAc)
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date')
            ->get()->map(function ($txn_detail) {
                $nextFindableEntryType = $txn_detail->entry_type == EntryType::$CR ? EntryType::$DR : EntryType::$CR;
                $t = TransactionDetail::query()
                    ->where('transaction_id', $txn_detail->transaction->id)
                    ->where('entry_type', $nextFindableEntryType)
                    ->first();
//                dump($t);
                return $t;

            })->reject(function ($item) {
                return $item == null;
            });
//        dd($txn_details);

        $data = ['start_date' => $start_date, 'end_date' => $end_date, 'branch_name' => $branch_name,
            'voucher_type' => $request->voucher_type,
            'txn_details' => $txn_details
        ];
        return $data;

    }

    /**
     * @return array
     */
    public function getDayBookReport($request)
    {
        $branch_id = $request->branch_id;
        $start_date = $request->start_date;
        $end_date = $request->end_date;

        $branch_name = optional(Branch::find($branch_id))->name ?? 'All';

        $txn_details = TransactionDetail::query()->when($branch_id != 'All', function ($query) use ($branch_id) {
            return $query->where('branch_id', $branch_id);
        })
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date')
            ->get()->reject(function ($item) {
                return $item == null || $item->note == "OpeningBalance";
            });
//        dd($txn_details);

        $data = ['start_date' => $start_date, 'end_date' => $end_date, 'branch_name' => $branch_name,
            'voucher_type' => $request->voucher_type,
            'txn_details' => $txn_details
        ];
        return $data;
    }

    public function getSecondRootParent($ledger)
    {

        $secondRootGroup = $ledger->ledgerGroup;
        try {
            $nextId = $ledger->ledger_group_id;
            while (true) {
                $group = LedgerGroup::find($nextId);
                if ($group->parent != -1) {
                    $nextId = $group->parent;
                    $secondRootGroup = $group;

                } else {
                    break;
                }
            }

        } catch (\Exception $exception) {
            // return $secondRootGroup;
        }
        return $secondRootGroup;

    }

    public function getRootParent($ledger)
    {

        $secondRootGroup = $ledger->ledgerGroup;
        try {
            $nextId = $ledger->ledger_group_id;
            while (true) {
                $group = LedgerGroup::find($nextId);
                if ($group->parent != -1) {
                    $nextId = $group->parent;

                } else {
                    $secondRootGroup = $group;

                    break;
                }
            }

        } catch (\Exception $exception) {
            // return $secondRootGroup;
        }
        return $secondRootGroup;

    }

    public function getRPBReport(Request $request)
    {
//        dd($request->all());
        $branches = Branch::all();
        $month = Carbon::parse($request->month)->month;
        $year = Carbon::parse($request->month)->year;
        $records = [];
        $ledgers = [];
        foreach ($branches as $branch) {
            $record = [];
            $receipt = Transaction::query()
                ->where('branch_id', $branch->id)
                ->where('txn_type', VoucherType::$RECEIVE)
                ->orWhere('txn_type', VoucherType::$CUSTOMER_PAYMENT)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->sum('amount');
            $record = ['revenue' => $receipt, 'branch' => $branch->name];


            $paymentReceipt = Transaction::query()
                ->where('branch_id', $branch->id)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->where('txn_type', VoucherType::$PAYMENT)
                ->orWhere('txn_type', VoucherType::$VENDOR_PAYMENT);
            $record['payment'] = $paymentReceipt->sum('amount');


            foreach ($paymentReceipt->get() as $paymentVoucher) {
                $txns = $paymentVoucher->transaction_details()
                    ->where('entry_type', EntryType::$DR)
                    ->get()
                    ->map(function ($txn) {
                        return ['ledger_name' => $txn->ledger->ledger_name, 'amount' => $txn->amount];
                    });

                if ($branch->name == 'Healthcare Pharmaceuticals Limited') {
//                    dd($paymentVoucher->transaction_details()->where('entry_type', EntryType::$DR)->get());
                }
                foreach ($txns as $txn) {
                    $ledgerName = $txn['ledger_name'];
                    if (array_key_exists($ledgerName, $record)) {
                        $record[$ledgerName] += $txn['amount'];

                    } else {
                        $record[$ledgerName] = $txn['amount'];
                    }
                    if (!in_array($ledgerName, $ledgers)) {
                        $ledgers[] = $ledgerName;
                    }
                }

            }

            array_push($records, $record);
        }
        foreach ($records as $index => $record) {
            $netRevenue = $record['revenue'] - $record['payment'];

            $records[$index]['net_revenue'] = $netRevenue;

        }
        $records = array_filter($records, function ($record) {
            if ($record['net_revenue'] == 0 && $record['revenue'] == 0) {
                return false;
            } else return true;
        });

//        dd($records, $ledgers);
        return array($records, $ledgers);


    }

}


