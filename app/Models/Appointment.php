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

    protected $appends = ['appointment_status'];

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
                // 1. If a status is already saved in the database, return it.
                if ($value) {
                    return $value;
                }

                // 2. If not, calculate it based on the date and time.
                if (empty($attributes['date'])) {
                   return $appointmentDateTime = Carbon::parse($attributes['date'] . ' ' . $attributes['time']);
                }

                // Combine date and time into a single Carbon instance
                $appointmentDateTime = Carbon::parse($attributes['date'] . ' ' . $attributes['time']);

                // 3. Compare with the current time and return the calculated status.
                return $appointmentDateTime->isPast() ? 'Completed' : 'Upcoming';
            }
        );
    }

     public function service(){
        return $this->belongsTo(Service::class,'service_id');
    }

    public function customer()
    {
        return $this->belongsTo(Contact::class,'contact_id');
    }
}
