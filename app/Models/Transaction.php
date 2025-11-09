<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'sub_type',
        'title',
        'amount',
        'notes',
        'date',
        'category',
        'payment_method',
        'contact_id',
        'project_id',
        'appointment_id',
        'invoice_id',
    ];



    protected $casts = [
        'amount' => 'decimal:2', // Casts the amount to a decimal with 2 places for currency
        'date' => 'date',   // Casts the payment_date to a Carbon date object
    ];


      // Define relationships to other models
    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function contact(): BelongsTo {
        return $this->belongsTo(Contact::class);
    }

    public function project(): BelongsTo {
        return $this->belongsTo(Project::class);
    }

    public function appointment(): BelongsTo {
        return $this->belongsTo(Appointment::class, );
    }

    public function invoice(): BelongsTo {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class);
    }




    /**
     * Get the user who owns this payment record.
     */

}
