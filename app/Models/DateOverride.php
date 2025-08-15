<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateOverride extends Model
{
    protected $fillable = [
        'user_id',
        'override_date',
    ];
}
