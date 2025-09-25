<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionItem extends Model
{

    use HasFactory;
    // protected $guarded = [];

    protected $fillable = [
        'user_id',
        'transaction_id',
        'description',
        'amount',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }


    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }
}
