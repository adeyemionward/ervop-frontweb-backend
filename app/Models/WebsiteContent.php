<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebsiteContent extends Model
{
    protected $fillable = [
        'user_id',
        'page',
        'section_type',
        'content_key',
        'content_value',
        'tokens_used',
        'word_count',
    ];

    // Optional: Relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
