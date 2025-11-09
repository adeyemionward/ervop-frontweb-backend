<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_project_id',
        'user_id',
        'contact_id',
        'project_id',
        'service_id',
        'title',
        'start_date',
        'end_date',
        'status',
        'progress_status',
        'cost',
        'description',
    ];


     public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }

    public function project(){
        return $this->belongsTo(Service::class,'project_id');
    }

    public function customer()
    {
        return $this->belongsTo(Contact::class,'contact_id');
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class, 'project_id'); // 👈 assumes invoices table has project_id
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'project_id'); // 👈 assumes invoices table has project_id
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'project_id'); // 👈 assumes documents table has project_id
    }

    public function notes()
    {
        return $this->hasMany(ProjectNote::class, 'project_id');
    }

    public function notesHistory()
    {
        return $this->hasMany(ProjectNote::class, 'project_id');
    }
}
