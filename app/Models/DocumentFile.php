<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentFile extends Model
{
     protected $fillable = [
        'user_id',
        'document_id',
        'contact_id',
        'file_path',
        'file_type',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id');
    }



    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function customer()
    {
        return $this->belongsTo(Contact::class,'contact_id');
    }



}
