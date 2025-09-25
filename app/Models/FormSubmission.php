<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'project_id',
        'contact_id',
        'user_id',
        'status',
        'token',
        'answers',
        'submitted_at',
    ];

    protected $casts = [
        'answers' => 'array', // Automatically cast the JSON answers column to an array
        'submitted_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
