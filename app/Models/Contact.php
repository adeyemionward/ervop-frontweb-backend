<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{

    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'email',
        'phone',
        'company',
        'photo',
        'tags',
        // 'status',
    ];



    protected $dates = ['deleted_at'];

    public function document() {
        return $this->hasMany(Document::class);
    }
}

