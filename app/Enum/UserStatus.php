<?php

namespace App\Enum;

// enum UserType
enum UserStatus: string
{
    case Active     = 'active';
    case Inactive   = 'inactive';
    case Banned     = 'banned';
    case Deactivate = 'deactivate';


    // Add a method to get the user type name
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    // Add a method to get the user type name
    public function name(): string
    {
        return match ($this) {
            self::Active        => 'Active',
            self::Inactive      => 'Inactive',
            self::Banned        => 'Banned',
            self::Deactivate    => 'Deactivate',
        };
    }
};
