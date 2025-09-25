<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{

    protected $fillable = [
        'user_id',
        'contact_id',
        'invoice_id',
        'appointment_id',
        'project_id',
        'amount',
        'payment_date',
        'payment_method',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     * This ensures data is always treated in the correct format.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2', // Casts the amount to a decimal with 2 places for currency
        'payment_date' => 'date',   // Casts the payment_date to a Carbon date object
    ];

  
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Get the user who owns this payment record.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contact associated with this payment.
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the appointment this payment is for (if applicable).
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the project this payment is for (if applicable).
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}


