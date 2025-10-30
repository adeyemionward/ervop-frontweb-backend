<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'appointment_id',
        'project_id',
        'quotation_no',
        'quotation_type',
        'issue_date',
        'valid_until',
        'tax_percentage',
        'discount_percentage',
        'tax_amount',
        'subtotal',
        'discount',
        'total',
        'notes',
        'status', // e.g. pending, accepted, rejected
    ];

    /**
     * Relationship: Each quotation has many items.
     */
    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * Relationship: Quotation belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship: Quotation belongs to a contact (customer).
     */
    public function customer()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }



    /**
     * Relationship: Quotation belongs to a project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Relationship: Quotation belongs to an appointment.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Generate a new quotation number (e.g. QUO-0001)
     */
    public static function generateQuotationNumber()
    {
        // Get the latest quotation
        $latestQuotation = self::orderBy('id', 'desc')->first();

        // Extract the last number or start from 0
        $lastNumber = 0;
        if ($latestQuotation && isset($latestQuotation->quotation_no)) {
            preg_match('/\d+$/', $latestQuotation->quotation_no, $matches);
            if (!empty($matches)) {
                $lastNumber = (int) $matches[0];
            }
        }

        // Increment and format to 4 digits
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Return formatted quotation number
        return 'QUO-' . $newNumber;
    }
}
