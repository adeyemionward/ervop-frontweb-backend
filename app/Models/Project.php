<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'title',
        'start_date',
        'end_date',
        'status',
        'progress_status',
        'cost',
        'description',
    ];
}
