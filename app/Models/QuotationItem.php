<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    protected $fillable = [
        'quotation_id',
        'appointment_id',
        'project_id',
        'user_id',
        'contact_id',
        'description',
        'quantity',
        'rate',
        'total',
    ];

    /**
     * Each item belongs to one quotation.
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    /**
     * Automatically calculate total when saving.
     */
    protected static function booted()
    {
        static::saving(function ($item) {
            $item->total = $item->quantity * $item->rate;
        });
    }
}
