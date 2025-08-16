<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'project_id',
        'title',
        'document_path',
        'tags',
    ];

    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }

    public function customer()
    {
        return $this->belongsTo(Contact::class,'contact_id');
    }
}
