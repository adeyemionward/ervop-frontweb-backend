<?php

namespace App\Models;

// use Attribute;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'contact_id',
        'service_id',
        'date',
        'time',
        'appointment_status',
        'notes',
    ];

   // protected $appends = ['appointment_status'];


    /**
     * Get the status of the appointment.
     *
     * If a status is already set in the database, it will be used.
     * Otherwise, it will be calculated based on the appointment date and time.
     */
    protected function appointmentStatus(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                // 1. If status already exists in DB, return it.
                if (!empty($value)) {
                    return $value;
                }

                // 2. If date or time is missing, return null (or a default value).
                if (empty($attributes['date']) || empty($attributes['time'])) {
                    return null;
                }

                // 3. Combine date and time into a Carbon instance.
                $appointmentDateTime = Carbon::parse($attributes['date'] . ' ' . $attributes['time']);

                // 4. Compare with the current time and return calculated status.
                return $appointmentDateTime->isPast() ? 'Completed' : 'Upcoming';
            }
        );
    }

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

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'appointment_id'); // 👈 assumes invoices table has appointment_id
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'appointment_id'); // 👈 assumes documents table has appointment_id
    }

    // public function notes()
    // {
    //     return $this->hasMany(AppointmentNote::class)->latest(); // Order by newest first
    // }

    public function notes()
    {
        return $this->hasMany(AppointmentNote::class, 'appointment_id');
    }

    public function notesHistory()
    {
        return $this->hasMany(AppointmentNote::class, 'appointment_id');
    }

}
