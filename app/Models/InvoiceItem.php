<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{

    protected $fillable = [
        'invoice_id',
        'user_id',
        'contact_id',
        'description',
        'quantity',
        'rate',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
