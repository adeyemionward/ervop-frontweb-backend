<?php

namespace App\Enum;

enum AppointmentStatus: string
{
    case UPCOMING = 'Upcoming';
    case INPROGRESS = 'Inprogress';
    case COMPLETED = 'Completed';
    case CONVERTED = 'Converted';
    case CANCELLED = 'Cancelled';
    case RESCHEDULED = 'Rescheduled';


    // Add a method to get the business type name
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    // Add a method to get the business type name
    public function name(): string
    {
        return match ($this) {
            self::UPCOMING  => 'Upcoming',
            self::INPROGRESS => 'Inprogress',
            self::COMPLETED => 'Completed',
            self::CONVERTED => 'Converted',
            self::CANCELLED => 'Cancelled',
            self::RESCHEDULED => 'Rescheduled',
        };
    }
};
