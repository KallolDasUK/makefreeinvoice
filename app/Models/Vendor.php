<?php

namespace App\Models;

use App\Http\Controllers\VendorsController;
use Enam\Acc\Models\Ledger;
use Enam\Acc\Models\TransactionDetail;
use Enam\Acc\Utils\EntryType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Vendor
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $photo
 * @property string|null $company_name
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $country
 * @property string|null $street_1
 * @property string|null $street_2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip_post
 * @property string|null $address
 * @property string|null $website
 * @property int|null $user_id
 * @property int|null $client_id
 * @property string|null $opening
 * @property string|null $opening_type
 * @property-read mixed $payables
 * @property-read mixed $previous_due
 * @method static Builder|Vendor newModelQuery()
 * @method static Builder|Vendor newQuery()
 * @method static Builder|Vendor query()
 * @method static Builder|Vendor whereAddress($value)
 * @method static Builder|Vendor whereCity($value)
 * @method static Builder|Vendor whereClientId($value)
 * @method static Builder|Vendor whereCompanyName($value)
 * @method static Builder|Vendor whereCountry($value)
 * @method static Builder|Vendor whereCreatedAt($value)
 * @method static Builder|Vendor whereEmail($value)
 * @method static Builder|Vendor whereId($value)
 * @method static Builder|Vendor whereName($value)
 * @method static Builder|Vendor whereOpening($value)
 * @method static Builder|Vendor whereOpeningType($value)
 * @method static Builder|Vendor wherePhone($value)
 * @method static Builder|Vendor wherePhoto($value)
 * @method static Builder|Vendor whereState($value)
 * @method static Builder|Vendor whereStreet1($value)
 * @method static Builder|Vendor whereStreet2($value)
 * @method static Builder|Vendor whereUpdatedAt($value)
 * @method static Builder|Vendor whereUserId($value)
 * @method static Builder|Vendor whereWebsite($value)
 * @method static Builder|Vendor whereZipPost($value)
 * @mixin \Eloquent
 */
class Vendor extends Model
{


    protected $table = 'vendors';


    protected $guarded = [];
    protected $appends = ['payables', 'advance'];


    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('scopeClient', function (Builder $builder) {
            if (optional(auth()->user())->client_id) {
                $builder->where('client_id', auth()->user()->client_id ?? -1);
            }
        });
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
            ->where('ledger_id',$this->ledger->id)
            ->where('type_id', $this->ledger->id)
            ->where('note', "OpeningBalance")
            ->where('entry_type', EntryType::$CR)
            ->sum('amount');
//        dd($debit,$credit);

        $due = $credit - $debit;
        if ($due < 0) {
            $due = 0;
        }
        return $due;
    }

    public function getPayablesAttribute()
    {

        if ($this->ledger->balance_type == 'Cr') {
            return $this->ledger->balance;
        }
        return 0;
    }


    public function getLedgerAttribute()
    {

        $ledger = Ledger::query()->where('type', Vendor::class)
            ->where('type_id', $this->id)
            ->first();
        if ($ledger == null) {
            $vendorController = new VendorsController();
            $ledger = $vendorController->createOrUpdateLedger($this);
        }
        return $ledger;
    }

    public function getAdvanceAttribute()
    {

        if ($this->ledger->balance_type == 'Dr') {
            return $this->ledger->balance;
        }
        return 0;
    }


}
