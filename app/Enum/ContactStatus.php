<?php

namespace App\Enum;

enum ContactStatus: string
{
    case Active   = 'active';
    case Inactive = 'inactive';


    // Add a method to get the business type name
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    // Add a method to get the business type name
    public function name(): string
    {
        return match ($this) {
            self::Active  => 'active',
            self::Inactive => 'inactive',
        };
    }
};
