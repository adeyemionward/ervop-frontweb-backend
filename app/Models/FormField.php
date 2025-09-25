<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormField extends Model
{
    protected $fillable = [
        'user_id',
        'form_id',
        'label',
        'type',
        'placeholder',
        'required',
        'options',
        'order',
    ];

    protected $casts = [
        'options' => 'array', // Automatically cast the JSON 'options' column to an array
        'required' => 'boolean',
    ];

    /**
     * Get the form that this field belongs to.
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}
