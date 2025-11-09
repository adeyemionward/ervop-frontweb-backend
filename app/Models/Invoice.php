<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'appointment_id',
        'project_id',
        'invoice_no',
        'invoice_type',
        'issue_date',
        'due_date',
        'tax_percentage',
        'discount_percentage',
        'tax_amount',
        'subtotal',
        'discount',
        'total',
        'is_recurring',
        'repeats',
        'occuring_start_date',
        'occuring_end_date',
        'notes',
        'remaining_balance',
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the user that owns the invoice.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the contact associated with the invoice.
     */
    public function customer()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    /**
     * Get the project associated with the invoice.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

   

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function payments()
    {
        return $this->hasMany(Transaction::class);
    }



    public static function generateInvoiceNumber()
    {
    // Get the latest invoice record
        $latestInvoice = self::orderBy('id', 'desc')->first();

        // Extract the last number or start from 0
        $lastNumber = 0;
        if ($latestInvoice && isset($latestInvoice->invoice_no)) {
            // Try to extract the numeric part, e.g. "INV-0012" → 12
            preg_match('/\d+$/', $latestInvoice->invoice_no, $matches);
            if (!empty($matches)) {
                $lastNumber = (int) $matches[0];
            }
        }

        // Increment and format to 4 digits
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Return formatted invoice number
        return 'INV-' . $newNumber;
    }


}
