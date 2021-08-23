<?php

namespace Enam\Acc\Models;

use Enam\Acc\Utils\EntryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\This;
use function PHPUnit\Framework\isEmpty;

class Ledger extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ledgers';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ledger_name',
        'ledger_group_id',
        'opening',
        'opening_type',
        'active',
        'date',
        'type'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the ledgerGroup for this model.
     *
     * @return Enam\Acc\Models\LedgerGroup
     */
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

}
