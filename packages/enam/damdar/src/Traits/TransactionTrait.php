<?php


namespace Enam\Acc\Traits;


use App\Models\Bill;
use App\Models\BillItem;
use App\Models\BillPaymentItem;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\PosItem;
use App\Models\PosPayment;
use App\Models\PosSale;
use App\Models\ReceivePaymentItem;
use Carbon\Carbon;
use Enam\Acc\Models\Branch;
use Enam\Acc\Models\GroupMap;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\LedgerGroup;
use Enam\Acc\Models\Transaction;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;
use Enam\Acc\Utils\LedgerHelper;
use Enam\Acc\Utils\Nature;
use Enam\Acc\Utils\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait TransactionTrait
{
    public $arr = [];

    protected function storeOpeningBalance(Ledger $ledger, $amount, $entry_type)
    {
        $txn = Transaction::where('txn_type', 'OpeningBalance')->where('type', Ledger::class)->where('type_id', $ledger->id)->first();
        if ($txn) {
            $txn->update([
                'amount' => $amount, 'type' => Ledger::class,
                'type_id' => $ledger->id
            ]);

            TransactionDetail::where('transaction_id', $txn->id)
                ->update([
                    'entry_type' => $entry_type, 'amount' => $amount, 'type' => Ledger::class,
                    'type_id' => $ledger->id
                ]);
            //            dd($txn);
        } else {
            $voucher_no = $this->getVoucherID();
            $txn = Transaction::create([
                'ledger_name' => $ledger->ledger_name, 'voucher_no' => $voucher_no,
                'amount' => $amount, 'note' => 'OpeningBalance', 'txn_type' => 'OpeningBalance', 'type' => Ledger::class,
                'type_id' => $ledger->id, 'date' => today()->toDateString()
            ]);

            TransactionDetail::create([
                'transaction_id' => $txn->id, 'ledger_id' => $ledger->id, 'entry_type' => $entry_type, 'amount' => $amount,
                'voucher_no' => $voucher_no, 'date' => today()->toDateString(), 'note' => 'OpeningBalance', 'type' => Ledger::class,
                'type_id' => $ledger->id
            ]);
        }
    }

    public function getChildLedgerGroup($id)
    {
        $groups = LedgerGroup::query()->where('parent', $id)->get();
        $ledger = Ledger::query()->where('ledger_group_id', $id);
        $ledger_id = $ledger->pluck('id')->toArray();
        foreach ($ledger_id as $id) {
            array_push($this->arr, $id);
        }


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


    public function getVoucherID($type = "VN", $increment = 1)
    {
        if ($type == "VN") {
            $totalAcc = Transaction::withoutTrashed()->where('voucher_no', 'like', '%VN%')->count();
        } else {
            $totalAcc = Transaction::withoutTrashed()->where('txn_type', $type)->count();
        }
        $totalAcc += $increment;
        $voucher_id = str_pad($totalAcc, 8, '0', STR_PAD_LEFT);

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
        //        dd($voucher_id);
        if (Transaction::withoutTrashed()->where('voucher_no', $voucher_id)->exists()) {
            return $this->getVoucherID($type, $increment + 1);
        }

        return $voucher;
    }

    public function getTrialBalanceReport($start, $end, $branch_id = null)
    {

        $ledgersWithFirstParent = [];
        $ledgers = Ledger::withTransactions($start, $end, $branch_id);

        $income = 0;
        $expense = 0;
        foreach ($ledgers as $ledger) {
            $group = $ledger->ledgerGroup->group_name ?? 'Others';

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


    public function getProfitLossReport($start_date, $end_date, $branch_id)
    {

        /* Income Query */
        $incomeLedgers = [];
        $totalIncome = 0;
        $income_ids = $this->getIncomeLedgers();
        foreach ($income_ids as $ledger_id) {
            $ledger = Ledger::find($ledger_id);
            if (is_null($ledger)) continue;
            $cr_amount = TransactionDetail::query()
                ->when($branch_id != 'All', function ($query) use ($branch_id) {
                    return $query->where('branch_id', $branch_id);
                })->whereBetween('date', [$start_date, $end_date])
                ->where('ledger_id', $ledger_id)
                ->where('entry_type', EntryType::$CR)->sum('amount');
            $dr_amount = TransactionDetail::query()
                ->when($branch_id != 'All', function ($query) use ($branch_id) {
                    return $query->where('branch_id', $branch_id);
                })->whereBetween('date', [$start_date, $end_date])
                ->where('ledger_id', $ledger_id)->where('entry_type', EntryType::$DR)->sum('amount');
            $amount = $cr_amount - $dr_amount;


            if (!$amount) continue;

            $incomeLedgers[$ledger->ledgerGroup->group_name][] = ['ledger_name' => $ledger->ledger_name, 'amount' => $amount, 'id' => $ledger->id];
            $totalIncome += $amount;
        }

        /* Expense Query */

        $expenseLedgers = [];
        $totalExpense = 0;

        $expense_ids = $this->getExpenseLedgers();
        foreach ($expense_ids as $ledger_id) {
            $ledger = Ledger::find($ledger_id);
            if (is_null($ledger)) continue;


            $cr_amount = TransactionDetail::query()
                ->when($branch_id != 'All', function ($query) use ($branch_id) {
                    return $query->where('branch_id', $branch_id);
                })->whereBetween('date', [$start_date, $end_date])
                ->where('ledger_id', $ledger_id)
                ->where('entry_type', EntryType::$CR)->sum('amount');
            $dr_amount = TransactionDetail::query()
                ->when($branch_id != 'All', function ($query) use ($branch_id) {
                    return $query->where('branch_id', $branch_id);
                })->whereBetween('date', [$start_date, $end_date])
                ->where('ledger_id', $ledger_id)->where('entry_type', EntryType::$DR)->sum('amount');
            $amount = $dr_amount - $cr_amount;

            if ($amount == 0) continue;
            //            dd($ledger, $amount, $dr_amount, $cr_amount);
            $expenseLedgers[$ledger->ledgerGroup->group_name][] = ['ledger_name' => $ledger->ledger_name, 'amount' => $amount, 'id' => $ledger->id];
            $totalExpense += $amount;
        }


        $data = [
            'expenseLedgers' => $expenseLedgers, 'incomeLedgers' => $incomeLedgers,
            'totalIncome' => $totalIncome, 'totalExpense' => $totalExpense
        ];

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
        $data = [
            'assetLedgers' => $assetLedgers, 'liabilitiesLedgers' => $liabilitiesLedger, 'start_date' => $request->start_date, 'end_date' => $request->end_date,
            'branch_name' => $branch_name, 'totalAsset' => $totalAsset, 'totalLiability' => $totalLiability, 'profit' => $profit
        ];

        return $data;
    }


    public function getLedgerReport($branch_id, $ledger_id, $start_date, $end_date, $prevent_opening = false)

    {

        $data = [
            'start_date' => $start_date, 'end_date' => $end_date,
            'ledger_name' => '', 'ledger' => '', 'records' => [],
            'opening_credit' => 0, 'opening_debit' => 0,
            'closing_credit' => 0, 'closing_debit' => 0
        ];

        $ledger = Ledger::find($ledger_id);
        if ($ledger == null) {
            return (object)$data;
        }
        $transaction_details = TransactionDetail::query()
            ->where('ledger_id', $ledger->id)
            ->when($branch_id != 'All', function ($query) use ($branch_id) {
                return $query->where('branch_id', $branch_id);
            })
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('created_at')->get();
        $transaction_details = $transaction_details->filter(function ($txn_item) {
            return !($txn_item->note == EntryType::$OPENING_BALANCE && $txn_item->voucher_no != null);
        });


        //      $testOpen =   DB::table('transaction_details')
        //            ->where('ledger_id', $ledger->id)
        //            ->where('entry_type', EntryType::$DR)
        ////            ->where('note', '!=', EntryType::$OPENING_BALANCE)
        //            ->where('date', '<', $start_date)
        //            ->sum('amount');

        //      dd($testOpen);
        $openingDebitTxn = TransactionDetail::query()
            ->where('ledger_id', $ledger->id)
            ->where('entry_type', EntryType::$DR)
            ->where('date', '<', $start_date)
            ->get();

        $openingDebitTxn = $openingDebitTxn->filter(function ($txn_item) {
            return !($txn_item->note == EntryType::$OPENING_BALANCE && $txn_item->voucher_no != null);
        });
        $openingDebit = $openingDebitTxn->sum('amount');


        $openingCreditTxn = TransactionDetail::query()
            ->where('ledger_id', $ledger->id)
            ->where('entry_type', EntryType::$CR)
            ->where('date', '<', $start_date)->get();

        $openingCreditTxn = $openingCreditTxn->filter(function ($txn_item) {
            return !($txn_item->note == EntryType::$OPENING_BALANCE && $txn_item->voucher_no != null);
        });
        $openingCredit = $openingCreditTxn->sum('amount');


        //        dd($openingDebit, $openingCredit);
        if ($prevent_opening) {
            $openingDebit = 0;
            $openingCredit = 0;
        }
        //        if ($ledger->id == 189) {
        //            dd($transaction_details, $openingDebit, $openingCredit);
        //        }


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
        //        dd($ledgerTransactions->toArray());
        $data = [
            'records' => $ledgerTransactions,
            'opening_credit' => $openingCredit, 'opening_debit' => $openingDebit,
            'closing_credit' => $closingCredit, 'closing_debit' => $closingDebit
        ];
        //        dd($data);
        return (object)$data;
    }


    public function getVoucherReport($branch_id, $voucher_type, $start_date, $end_date)
    {

        $txns = Transaction::query()->when($branch_id != 'All', function ($query) use ($branch_id) {
            return $query->where('branch_id', $branch_id);
        })
            ->where('txn_type', $voucher_type)
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date')
            ->get();

        return $txns;
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

        $data = [
            'start_date' => $start_date, 'end_date' => $end_date, 'branch_name' => $branch_name,
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

        $txn_details = TransactionDetail::query()
            ->when($branch_id != 'All', function ($query) use ($branch_id) {
                return $query->where('branch_id', $branch_id);
            })
            ->whereBetween('date', [$start_date, $end_date])
            ->orderBy('date')
            ->get()->reject(function ($item) {
                return $item == null || $item->note == "OpeningBalance";
            });
        //        dd($txn_details);

        $data = [
            'start_date' => $start_date, 'end_date' => $end_date, 'branch_name' => $branch_name,
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

        return array($records, $ledgers);
    }


    public function getPaymentReport($branch_id, $start_date, $end_date)
    {
        //        dd($start_date, $end_date,Carbon::parse($end_date)->addDay()->toDateString());
        $records = Transaction::query()
            //            ->where('date', '<', $start_date)
            //            ->where('date', '>', $end_date)

            ->when($branch_id != 'All', function ($query) use ($branch_id) {
                return $query->where('branch_id', $branch_id);
            })
            ->whereBetween('date', [$start_date, $end_date])
            ->whereIn('txn_type', [VoucherType::$VENDOR_PAYMENT, VoucherType::$PAYMENT])->get();
        //        dd($records);
        return $records;
    }

    public function getReceiptReport($branch_id, $start_date, $end_date)
    {
        $records = Transaction::query()
            ->whereBetween('date', [$start_date, $end_date])
            ->when($branch_id != 'All', function ($query) use ($branch_id) {
                return $query->where('branch_id', $branch_id);
            })
            ->whereIn('txn_type', [VoucherType::$CUSTOMER_PAYMENT, VoucherType::$RECEIVE])->get();
        //        dd($records);
        return $records;
    }

    public function getSalesReport($start_date, $end_date, $customer_id, $invoice_id, $payment_status, $user_id)
    {
        $records = [];
        $invoices = Invoice::query()
            ->whereBetween('invoice_date', [$start_date, $end_date])
            ->when($customer_id != null, function ($query) use ($customer_id) {
                return $query->where('customer_id', $customer_id);
            })
            ->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->when($invoice_id != null, function ($query) use ($invoice_id) {
                return $query->where('invoice_number', $invoice_id);
            })->when($payment_status != null, function ($query) use ($payment_status) {
                return $query->where('payment_status', $payment_status);
            })->get();

        foreach ($invoices as $invoice) {
            $record = [
                'date' => $invoice->invoice_date, 'invoice' => $invoice->invoice_number, 'customer' => optional($invoice->customer)->name, 'sub_total' => $invoice->sub_total, 'discount' => $invoice->discount, 'charges' => $invoice->charges, 'total' => $invoice->total,
                'payment' => $invoice->payment, 'due' => $invoice->due
            ];
            $records[] = (object)$record;
        }


        $pos_sales = PosSale::query()
            ->whereBetween('date', [$start_date, $end_date])
            ->when($customer_id != null, function ($query) use ($customer_id) {
                return $query->where('customer_id', $customer_id);
            })
            ->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })->when($invoice_id != null, function ($query) use ($invoice_id) {
                return $query->where('pos_number', $invoice_id);
            })->when($payment_status != null, function ($query) use ($payment_status) {
                return $query->where('pos_status', $payment_status);
            })->get();
        foreach ($pos_sales as $pos_sale) {
            $record = [
                'date' => $pos_sale->date, 'invoice' => $pos_sale->pos_number, 'customer' => optional($pos_sale->customer)->name, 'sub_total' => $pos_sale->sub_total, 'discount' => $pos_sale->discount, 'charges' => $pos_sale->charges, 'total' => $pos_sale->total,
                'payment' => $pos_sale->payment, 'due' => $pos_sale->due
            ];
            $records[] = (object)$record;
        }


        return collect($records)->sortBy('date', null, true);
    }

    public function getSalesReportDetails($start_date, $end_date, $customer_id, $invoice_id, $product_id, $brand_id, $category_id,$user_id)
    {
        $records = [];
        $invoice_items = InvoiceItem::query()->with(['product', 'invoice'])
            ->whereBetween('date', [$start_date, $end_date])
            ->whereHas('product', function ($query) use ($product_id) {
                return $query->when($product_id != null, function ($query) use ($product_id) {
                    return $query->where('id', $product_id);
                });
            })->whereHas('product', function ($query) use ($brand_id) {
                return $query->when($brand_id != null, function ($query) use ($brand_id) {
                    return $query->where('brand_id', $brand_id);
                });
            })->whereHas('product', function ($query) use ($category_id) {
                return $query->when($category_id != null, function ($query) use ($category_id) {
                    return $query->where('category_id', $category_id);
                });
            })->whereHas('invoice', function ($query) use ($invoice_id) {
                return $query->when($invoice_id != null, function ($query) use ($invoice_id) {
                    return $query->where('invoice_number', $invoice_id);
                });
            })->whereHas('invoice', function ($query) use ($customer_id) {
                return $query->when($customer_id != null, function ($query) use ($customer_id) {
                    return $query->where('customer_id', $customer_id);
                });
            })
            ->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->get();
        foreach ($invoice_items as $invoice_item) {
            $record = ['date' => '', 'invoice' => '', 'brand' => '', 'category' => '', 'customer' => '', 'product' => '', 'qnt' => '', 'amount' => '', 'total' => ''];
            $record['date'] = $invoice_item->date;
            $record['is_invoice'] = true;
            $record['invoice'] = optional($invoice_item->invoice)->invoice_number;
            $record['brand'] = optional(optional($invoice_item->product)->brand)->name;
            $record['category'] = optional(optional($invoice_item->product)->category)->name;
            $record['customer'] = optional(optional($invoice_item->invoice)->customer)->name;
            $record['product'] = optional($invoice_item->product)->name;
            $record['qnt'] = floatval($invoice_item->qnt);
            $record['amount'] = $invoice_item->amount;
            $record['total'] = $invoice_item->qnt * $invoice_item->amount;
            $records[] = (object)$record;
        }

        $pos_items = PosItem::query()->with(['product', 'pos_sale'])
            ->whereBetween('date', [$start_date, $end_date])
            ->whereHas('product', function ($query) use ($product_id) {
                return $query->when($product_id != null, function ($query) use ($product_id) {
                    return $query->where('id', $product_id);
                });
            })->whereHas('product', function ($query) use ($brand_id) {
                return $query->when($brand_id != null, function ($query) use ($brand_id) {
                    return $query->where('brand_id', $brand_id);
                });
            })->whereHas('product', function ($query) use ($category_id) {
                return $query->when($category_id != null, function ($query) use ($category_id) {
                    return $query->where('category_id', $category_id);
                });
            })->whereHas('pos_sale', function ($query) use ($invoice_id) {
                return $query->when($invoice_id != null, function ($query) use ($invoice_id) {
                    return $query->where('pos_number', $invoice_id);
                });
            })->whereHas('pos_sale', function ($query) use ($customer_id) {
                return $query->when($customer_id != null, function ($query) use ($customer_id) {
                    return $query->where('customer_id', $customer_id);
                });
            })
            ->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->get();
        foreach ($pos_items as $pos_item) {
            $record = ['date' => '', 'invoice' => '', 'brand' => '', 'category' => '', 'customer' => '', 'product' => '', 'qnt' => '', 'amount' => '', 'total' => ''];
            $record['date'] = $pos_item->date;
            $record['is_invoice'] = false;
            $record['invoice'] = optional($pos_item->pos_sale)->pos_number;
            $record['brand'] = optional(optional($pos_item->product)->brand)->name;
            $record['category'] = optional(optional($pos_item->product)->category)->name;
            $record['customer'] = optional(optional($pos_item->pos_sale)->customer)->name;
            $record['product'] = optional($pos_item->product)->name;
            $record['qnt'] = floatval($pos_item->qnt);
            $record['amount'] = $pos_item->price;
            $record['total'] = $pos_item->qnt * $pos_item->price;
            $records[] = (object)$record;
        }


        //        dd($records);
        return collect($records)->sortBy('date', null, true);
    }

    public function getPurchaseReport($start_date, $end_date, $vendor_id, $bill_Id, $payment_status)
    {
        $records = Bill::query()
            ->whereBetween('bill_date', [$start_date, $end_date])
            ->when($vendor_id != null, function ($query) use ($vendor_id) {
                return $query->where('customer_id', $vendor_id);
            })->when($bill_Id != null, function ($query) use ($bill_Id) {
                return $query->where('id', $bill_Id);
            })->when($payment_status != null, function ($query) use ($payment_status) {
                return $query->where('payment_status', $payment_status);
            })->get();
        return $records;
    }

    public function getPurchaseReportDetails($start_date, $end_date, $vendor_id, $bill_id, $product_id, $brand_id, $category_id, $user_id)
    {
        $records = [];
        $bill_items = BillItem::query()->with(['product', 'bill'])
            ->whereBetween('date', [$start_date, $end_date])
            ->whereHas('product', function ($query) use ($product_id) {
                return $query->when($product_id != null, function ($query) use ($product_id) {
                    return $query->where('id', $product_id);
                });
            })->whereHas('product', function ($query) use ($brand_id) {
                return $query->when($brand_id != null, function ($query) use ($brand_id) {
                    return $query->where('brand_id', $brand_id);
                });
            })->whereHas('product', function ($query) use ($category_id) {
                return $query->when($category_id != null, function ($query) use ($category_id) {
                    return $query->where('category_id', $category_id);
                });
            })->whereHas('bill', function ($query) use ($bill_id) {
                return $query->when($bill_id != null, function ($query) use ($bill_id) {
                    return $query->where('bill_number', $bill_id);
                });
            })->whereHas('bill', function ($query) use ($vendor_id) {
                return $query->when($vendor_id != null, function ($query) use ($vendor_id) {
                    return $query->where('vendor_id', $vendor_id);
                });
            })->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->get();
        foreach ($bill_items as $bill_item) {
            $record = ['date' => '', 'bill' => '', 'brand' => '', 'category' => '', 'vendor' => '', 'product' => '', 'qnt' => '', 'amount' => '', 'total' => ''];
            $record['date'] = $bill_item->date;
            $record['is_bill'] = true;
            $record['bill'] = optional($bill_item->bill)->bill_number;
            $record['brand'] = optional(optional($bill_item->product)->brand)->name;
            $record['category'] = optional(optional($bill_item->product)->category)->name;
            $record['vendor'] = optional(optional($bill_item->bill)->vendor)->name;
            $record['product'] = optional($bill_item->product)->name;
            $record['qnt'] = floatval($bill_item->qnt);
            $record['amount'] = $bill_item->price;
            $record['total'] = $bill_item->qnt * $bill_item->price;
            $records[] = (object)$record;
        }
        return collect($records)->sortBy('date', null, true);
    }

    public function getDueCollectionReport($start_date, $end_date, $customer_id,$user_id)
    {
        $records = [];
        $rp_items = ReceivePaymentItem::query()->with('receive_payment')
            ->whereHas('receive_payment', function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('payment_date', [$start_date, $end_date]);
            })
            ->whereHas('receive_payment', function ($query) use ($customer_id) {
                return $query->when($customer_id != null, function ($query) use ($customer_id) {
                    return $query->where('customer_id', $customer_id);
                });
            })
            ->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })->get();
        foreach ($rp_items as $item) {
            $record = ['customer' => '', 'amount' => '', 'date' => '', 'payment_sl' => '', 'method' => ''];
            $record['customer'] = optional($item->receive_payment->customer)->name;
            $record['date'] = optional($item->receive_payment)->payment_date;
            $record['invoice'] = optional($item->invoice)->invoice_number;
            $record['method'] = optional($item->receive_payment->ledger)->ledger_name;
            $record['amount'] = $item->amount;
            $records[] = (object)$record;
        }
        $pos_payments = PosPayment::query()->with('pos_sale')
            ->whereBetween('date', [$start_date, $end_date])
            ->whereHas('pos_sale', function ($query) use ($customer_id) {
                return $query->when($customer_id != null, function ($query) use ($customer_id) {
                    return $query->where('customer_id', $customer_id);
                });
            }) ->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })->get();
        foreach ($pos_payments as $payment) {
            $record = ['customer' => '', 'amount' => '', 'date' => '', 'payment_sl' => '', 'method' => ''];
            $record['customer'] = optional(optional($payment->pos_sale)->customer)->name;
            $record['date'] = $payment->date;
            $record['invoice'] = optional($payment->pos_sale)->pos_number;
            $record['method'] = optional($payment->ledger)->ledger_name;
            $record['amount'] = $payment->amount;
            $records[] = (object)$record;
        }

        //        dd($pos_payments);

        return collect($records)->sortBy('date', null, true);
    }

    public function getDuePaymentReport($start_date, $end_date, $vendor_id,$user_id)
    {
        $records = [];
        $rp_items = BillPaymentItem::query()->with('bill_payment')
            ->whereHas('bill_payment', function ($query) use ($start_date, $end_date) {
                return $query->whereBetween('payment_date', [$start_date, $end_date]);
            })
            ->whereHas('bill_payment', function ($query) use ($vendor_id) {
                return $query->when($vendor_id != null, function ($query) use ($vendor_id) {
                    return $query->where('vendor_id', $vendor_id);
                });
            })
            ->when($user_id != null, function ($query) use ($user_id) {
                return $query->where('user_id', $user_id);
            })
            ->get();
        foreach ($rp_items as $item) {
            $record = ['vendor' => '', 'amount' => '', 'date' => '', 'payment_sl' => '', 'method' => ''];
            $record['vendor'] = optional($item->bill_payment->vendor)->name;
            $record['date'] = optional($item->bill_payment)->payment_date;
            $record['bill'] = optional($item->bill)->bill_number;
            $record['method'] = optional($item->bill_payment->ledger)->ledger_name;
            $record['amount'] = $item->amount;
            $records[] = (object)$record;
        }


        //        dd($pos_payments);

        return collect($records)->sortBy('date', null, true);
    }
}
