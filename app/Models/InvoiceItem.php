<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{

    protected $fillable = [
        'invoice_id',
        'appointment_id',
        'project_id',
        'user_id',
        'contact_id',
        'description',
        'quantity',
        'rate',
        'total'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
