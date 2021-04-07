<?php

namespace Enam\Acc\Models;

use Enam\Acc\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }
}
