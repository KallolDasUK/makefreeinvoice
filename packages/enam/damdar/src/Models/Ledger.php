<?php

namespace Enam\Acc\Models;

use Enam\Acc\Traits\TransactionTrait;
use Enam\Acc\Utils\EntryType;
use Enam\Acc\Utils\LedgerHelper;
use Enam\Acc\Utils\Nature;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\This;
use function PHPUnit\Framework\isEmpty;

class Ledger extends Model
{
    use SoftDeletes;
    use TransactionTrait;


    protected $fillable = [
        'ledger_name',
        'ledger_group_id',
        'opening',
        'opening_type',
        'active',
        'date',
        'type'
    ];


    public function ledgerGroup()
    {
        return $this->belongsTo('Enam\Acc\Models\LedgerGroup', 'ledger_group_id');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    protected static function getLedgerBalance($trQuery, $withBracket = true)
    {
        $totalCr = $trQuery->where('entry_type', EntryType::$CR)->sum('amount');
        $totalDr = $trQuery->where('entry_type', EntryType::$DR)->sum('amount');
        $currentBalance = 0;
        $postFix = '';
        if ($totalDr > $totalCr) {
            $currentBalance = $totalDr - $totalCr;
            $postFix = ' (' . $currentBalance . 'Dr)';
        } else if ($totalCr > $totalDr) {
            $currentBalance = $totalCr - $totalDr;
            $postFix = '(' . $currentBalance . 'Cr)';
        }
        if (!$withBracket) {
            $postFix = str_replace('(', ' ', $postFix);
            $postFix = str_replace(')', ' ', $postFix);
        }
//        dd($postFix);
        return $postFix;


    }

    public static function allWithCrDr()
    {
        return self::query()->get()->map(function ($ledger) {
            $postFix = self::getLedgerBalance($ledger->transaction_details);
            $ledger->ledger_name = $ledger->ledger_name . ' ' . $postFix;
            return $ledger;
        });
    }

    public static function withTransactions($start_date, $end_date, $branch_id)
    {
        return self::query()->get()->map(function ($ledger) use ($start_date, $end_date, $branch_id) {
            $openingBalance = 0;
            $transaction_details = $ledger->transaction_details()
                ->where('type', '!=', Ledger::class)
                ->where('ledger_id', $ledger->id)
                ->when($branch_id != 'All', function ($query) use ($branch_id) {
                    return $query->where('branch_id', $branch_id);
                })
                ->whereBetween('date', [$start_date, $end_date])->get();


            // Opening Balance
            $opening_tr = $ledger->transaction_details()
                ->where('note', '!=', "OpeningBalance")
                ->when($branch_id != 'All', function ($query) use ($branch_id) {
                    return $query->where('branch_id', $branch_id);
                })->whereDate('date', '<', $start_date)->get();


            $openingBalance = self::getLedgerBalance($opening_tr, false);
            $totalFreshAmount = floatval(str_replace('Cr', '', str_replace('Dr', '', $openingBalance)));
            $openingBalanceType = null;
            if (Str::contains($openingBalance, EntryType::$DR)) {
                $openingBalanceType = EntryType::$DR;
            } elseif (Str::contains($openingBalance, EntryType::$CR)) {
                $openingBalanceType = EntryType::$CR;
            }
            $openingBalanceTransaction = TransactionDetail::query()
                ->where('ledger_id', $ledger->id)
                ->where('note', "OpeningBalance")
                ->first();

            if ($openingBalanceTransaction) {
                if ($openingBalanceType === $openingBalanceTransaction->entry_type) {
                    $totalFreshAmount = $openingBalanceTransaction->amount + $totalFreshAmount;
                } else {
                    $totalFreshAmount = $openingBalanceTransaction->amount - $totalFreshAmount;
                    if ($totalFreshAmount > 0) {
                        $openingBalanceType = $openingBalanceTransaction->entry_type;
//                        dd($openingBalanceType);
                    }
                }
//                dd($totalFreshAmount);
            }


            $totalDebit = $transaction_details->where('entry_type', EntryType::$DR)->sum('amount');
            $totalCredit = $transaction_details->where('entry_type', EntryType::$CR)->sum('amount');


//            dump(TransactionDetail::query()
//                ->where('ledger_id', $ledger->id)->get(),$ledger->ledger_name);


            $closingDebit = 0;
            $closingCredit = 0;
            $newTotalDebit = $totalDebit;
            $newTotalCredit = $totalCredit;


            if ($openingBalanceType === EntryType::$DR) {
                $newTotalDebit = $totalDebit + $totalFreshAmount;
            } elseif ($openingBalanceType === EntryType::$CR) {
                $newTotalCredit = $totalCredit + $totalFreshAmount;
            } else {
                if ($totalDebit > $totalCredit) {
                    $closingDebit = $totalDebit - $totalCredit;
                } else if ($totalCredit > $totalDebit) {
                    $closingCredit = $totalCredit - $totalDebit;
//                dd($totalFreshAmount,$totalCredit,$totalDebit);

                }
            }

            if ($newTotalDebit > $newTotalCredit) {
                $closingDebit = $newTotalDebit - $newTotalCredit;
//                dd('debit', $openingBalance);
            } else if ($newTotalCredit > $newTotalDebit) {
//                dd('credit', $openingBalance, $newTotalCredit, $totalDebit);

                $closingCredit = $newTotalCredit - $newTotalDebit;
            }
            if ($totalFreshAmount) {
//                dump(['openingBalance' => $openingBalance, 'closing_debit' => $closingDebit, 'closing_credit' => $closingCredit, 'total_debit' => $totalDebit, 'newTotalDebit' => $newTotalDebit]);
            }

            /* Saving to Ledger Instance */
            $ledger->opening_balance = $totalFreshAmount;
            $ledger->total_debit = $totalDebit;
            $ledger->total_credit = $totalCredit;
            $ledger->trd = $transaction_details;
            $ledger->opening_balance_type = $openingBalanceType;

            $ledger->closing_debit = $closingDebit;
            $ledger->closing_credit = $closingCredit;


            return $ledger;
        })->reject(function ($ledger) {
//            dd($ledger);
            if ($ledger->total_debit === 0 && $ledger->total_credit === 0) {
                return true;
            } else {
                return false;
            }
        });
    }

    public function getDrAttribute()
    {

        return $this->transaction_details->where('entry_type', EntryType::$DR)->sum('amount');
    }

    public function getCrAttribute()
    {
        return $this->transaction_details->where('entry_type', EntryType::$CR)->sum('amount');
    }

    public function getBalanceTypeAttribute()
    {

        $totalCr = $this->cr;
        $totalDr = $this->dr;
        $currentBalance = 0;
        $type = '';
        if ($totalDr > $totalCr) {
            $currentBalance = $totalDr - $totalCr;
            $type = "Dr";
        } else if ($totalCr > $totalDr) {
            $currentBalance = $totalCr - $totalDr;
            $type = "Cr";
        }
        return $type;
    }

    public function getBalanceAttribute()
    {

        $totalCr = $this->cr;
        $totalDr = $this->dr;
        $currentBalance = 0;
        $type = '';
        if ($totalDr > $totalCr) {
            $currentBalance = $totalDr - $totalCr;
            $type = "Dr";
        } else if ($totalCr > $totalDr) {
            $currentBalance = $totalCr - $totalDr;
            $type = "Cr";
        }
        return $currentBalance;
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('scopeClient', function (Builder $builder) {
            if (optional(auth()->user())->client_id) {
                $builder->where('client_id', auth()->user()->client_id ?? -1);
            }
        });
    }

    public static function CASH_AC()
    {
        return GroupMap::query()->where('key', LedgerHelper::$CASH_AC)->first()->value ?? null;
    }

    public static function PURCHASE_AC()
    {
        return GroupMap::query()->where('key', LedgerHelper::$PURCHASE_AC)->first()->value ?? null;
    }

    public static function COST_OF_GOODS_SOLD()
    {
        return GroupMap::query()->where('key', LedgerHelper::$COST_OF_GOODS_SOLD)->first()->value ?? null;
    }

    public function getNatureAttribute()
    {
        $group = LedgerGroup::find($this->ledger_group_id);

        return $this->nature($group);
    }

    public function nature($group)
    {
        if ($group->parent != -1) {
            $g = LedgerGroup::find($group->parent);
            return $this->nature($g);
        } else {
            return $group->nature;
        }
    }

    public function closingBalance($branch_id, $start_date, $end_date)
    {

        $report = $this->getLedgerReport($branch_id, $this->id, $start_date, $end_date);
        $nature = $this->nature;
        if ($nature == Nature::$ASSET) {
            return $report->closing_debit - $report->closing_credit;
        } elseif ($nature == Nature::$LIABILITIES) {
            return $report->closing_credit - $report->closing_debit;
        } elseif ($nature == Nature::$EXPENSE) {
            return $report->closing_debit - $report->closing_credit;
        } elseif ($nature == Nature::$Income) {
            return $report->closing_credit - $report->closing_debit;
        }
        return $report->closing_credit + $report->closing_debit;
    }
}
