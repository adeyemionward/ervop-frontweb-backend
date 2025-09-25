<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title','last_used','submissions_count'];

    /**
     * Get the fields for the form, ordered correctly.
     */
    public function fields()
    {
        return $this->hasMany(FormField::class)->orderBy('order');
    }

    /**
     * Get the user that owns the form.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(FormSubmission::class, 'form_id');
    }
}
