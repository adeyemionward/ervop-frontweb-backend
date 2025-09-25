<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'appointment_id',
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

    public function customer()
    {
        return $this->belongsTo(Contact::class,'contact_id');
    }
}
