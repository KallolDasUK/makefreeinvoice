<?php

namespace App\Models;

use App\Http\Controllers\CustomersController;
use App\Http\Controllers\VendorsController;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Customer
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $company_name
 * @property string|null $phone
 * @property string|null $date
 * @property string|null $email
 * @property string|null $address
 * @property string|null $website
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $country
 * @property string|null $street_1
 * @property string|null $street_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_post
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string|null $opening
 * @property string|null $opening_type
 * @property-read mixed $previous_due
 * @property-read mixed $receivables
 * @method static Builder|Customer newModelQuery()
 * @method static Builder|Customer newQuery()
 * @method static Builder|Customer query()
 * @method static Builder|Customer whereAddress($value)
 * @method static Builder|Customer whereCity($value)
 * @method static Builder|Customer whereClientId($value)
 * @method static Builder|Customer whereCompanyName($value)
 * @method static Builder|Customer whereCountry($value)
 * @method static Builder|Customer whereCreatedAt($value)
 * @method static Builder|Customer whereEmail($value)
 * @method static Builder|Customer whereId($value)
 * @method static Builder|Customer whereName($value)
 * @method static Builder|Customer whereOpening($value)
 * @method static Builder|Customer whereOpeningType($value)
 * @method static Builder|Customer wherePhone($value)
 * @method static Builder|Customer wherePhoto($value)
 * @method static Builder|Customer whereState($value)
 * @method static Builder|Customer whereStreet1($value)
 * @method static Builder|Customer whereStreet2($value)
 * @method static Builder|Customer whereUpdatedAt($value)
 * @method static Builder|Customer whereUserId($value)
 * @method static Builder|Customer whereWebsite($value)
 * @method static Builder|Customer whereZipPost($value)
 * @mixin \Eloquent
 */
class Customer extends Model
{

    const WALK_IN_CUSTOMER = "Walk In Customer";

    protected $guarded = [];
    protected $appends = ['advance', 'receivables'];



    public function getAddressAttribute()
    {
        $address = '';

        if ($this->street_1 ?? false) {
            $address .= $this->street_1;
        }
        if ($this->street_2 ?? false) {
            $address .= ',' . $this->street_2;
        }
        if ($this->state ?? false) {
            $address .= ',' . $this->state;
        }
        if ($this->zip_post ?? false) {
            $address .= ',' . $this->zip_post;
        }
        return $address;

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

    public static function WALKING_CUSTOMER()
    {
        return self::query()->firstOrCreate(['name' => self::WALK_IN_CUSTOMER], ['name' => self::WALK_IN_CUSTOMER]);
    }

    public function getLedgerAttribute()
    {
        $ledger = Ledger::query()->where('type', Customer::class)
            ->where('type_id', $this->id)
            ->first();

        if ($ledger == null) {
            $customerController = new CustomersController();
            $ledger = $customerController->createOrUpdateLedger($this);
        }

        return $ledger;
    }

    public function getPreviousDueAttribute()
    {
        $debit = TransactionDetail::query()
            ->where('type', Ledger::class)
            ->where('type_id', $this->ledger->id)
            ->where('ledger_id',$this->ledger->id)
            ->where('entry_type', EntryType::$DR)
            ->where('note', "OpeningBalance")
            ->sum('amount');

        $credit = TransactionDetail::query()
            ->where('type', Ledger::class)
            ->where('type_id', $this->ledger->id)
            ->where('ledger_id',$this->ledger->id)
            ->where('entry_type', EntryType::$CR)
            ->where('note', "OpeningBalance")
            ->sum('amount');
//        dd($debit,$credit);
        $due = $debit - $credit;
        if ($due < 0) {
            $due = 0;
        }
        return $due;
    }


    public function getReceivablesAttribute()
    {

        if ($this->ledger->balance_type == 'Dr') {
            return $this->ledger->balance;
        }
        return 0;
    }

    public function getAdvanceAttribute()
    {
        if ($this->ledger->balance_type == 'Cr') {
            return $this->ledger->balance;
        }
        return 0;
    }


}
