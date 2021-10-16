<?php

namespace App\Models;

use Enam\Acc\Models\Ledger;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PosPayment
 *
 * @property int $id
 * @property int|null $pos_sales_id
 * @property int|null $payment_method_id
 * @property string|null $amount
 * @property string|null $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $ledger_id
 * @property int|null $receive_payment_id
 * @property int|null $user_id
 * @property int|null $client_id
 * @property-read Ledger|null $ledger
 * @property-read \App\Models\PosSale|null $pos_sale
 * @method static Builder|PosPayment newModelQuery()
 * @method static Builder|PosPayment newQuery()
 * @method static Builder|PosPayment query()
 * @method static Builder|PosPayment whereAmount($value)
 * @method static Builder|PosPayment whereClientId($value)
 * @method static Builder|PosPayment whereCreatedAt($value)
 * @method static Builder|PosPayment whereDate($value)
 * @method static Builder|PosPayment whereId($value)
 * @method static Builder|PosPayment whereLedgerId($value)
 * @method static Builder|PosPayment wherePaymentMethodId($value)
 * @method static Builder|PosPayment wherePosSalesId($value)
 * @method static Builder|PosPayment whereReceivePaymentId($value)
 * @method static Builder|PosPayment whereUpdatedAt($value)
 * @method static Builder|PosPayment whereUserId($value)
 * @mixin \Eloquent
 */
class PosPayment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function pos_sale()
    {
        return $this->belongsTo(PosSale::class, 'pos_sales_id');
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
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
