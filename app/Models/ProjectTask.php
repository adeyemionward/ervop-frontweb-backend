<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
     protected $fillable = [
        'user_id',
        'contact_id',
        'status',
        'task',
    ];
}
