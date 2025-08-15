<?php
namespace App\Enum;

// enum BusinessType
enum BusinessType: string
{
    case Professional   = 'professional';
    case Seller         = 'seller';
    case Hybrid         = 'hybrid';


    // Add a method to get the business type name
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
    // Add a method to get the business type name
    public function name(): string
    {
        return match ($this) {
            self::Professional  => 'Professional',
            self::Seller        => 'Seller',
            self::Hybrid        => 'Hybrid',
        };
    }
};


