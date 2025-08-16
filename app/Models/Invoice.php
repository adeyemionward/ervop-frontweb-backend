<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'project_id',
        'invoice_no',
        'invoice_type',
        'issue_date',
        'due_date',
        'tax',
        'discount',
        'notes',
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
        return $this->belongsTo(Contact::class);
    }

    /**
     * Get the project associated with the invoice.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
