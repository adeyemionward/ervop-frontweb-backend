<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    public function run(): void
    {
        $currencies = [
            ['code' => 'AED', 'name' => 'United Arab Emirates Dirham', 'symbol' => 'د.إ'],
            ['code' => 'AFN', 'name' => 'Afghan Afghani', 'symbol' => '؋'],
            ['code' => 'ALL', 'name' => 'Albanian Lek', 'symbol' => 'L'],
            ['code' => 'AMD', 'name' => 'Armenian Dram', 'symbol' => '֏'],
            ['code' => 'ANG', 'name' => 'Netherlands Antillean Guilder', 'symbol' => 'ƒ'],
            ['code' => 'AOA', 'name' => 'Angolan Kwanza', 'symbol' => 'Kz'],
            ['code' => 'ARS', 'name' => 'Argentine Peso', 'symbol' => '$'],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$'],
            ['code' => 'AWG', 'name' => 'Aruban Florin', 'symbol' => 'ƒ'],
            ['code' => 'AZN', 'name' => 'Azerbaijani Manat', 'symbol' => '₼'],
            ['code' => 'BAM', 'name' => 'Bosnia-Herzegovina Convertible Mark', 'symbol' => 'KM'],
            ['code' => 'BBD', 'name' => 'Barbadian Dollar', 'symbol' => 'Bds$'],
            ['code' => 'BDT', 'name' => 'Bangladeshi Taka', 'symbol' => '৳'],
            ['code' => 'BGN', 'name' => 'Bulgarian Lev', 'symbol' => 'лв'],
            ['code' => 'BHD', 'name' => 'Bahraini Dinar', 'symbol' => '.د.ب'],
            ['code' => 'BIF', 'name' => 'Burundian Franc', 'symbol' => 'FBu'],
            ['code' => 'BMD', 'name' => 'Bermudian Dollar', 'symbol' => 'BD$'],
            ['code' => 'BND', 'name' => 'Brunei Dollar', 'symbol' => 'B$'],
            ['code' => 'BOB', 'name' => 'Bolivian Boliviano', 'symbol' => 'Bs.'],
            ['code' => 'BRL', 'name' => 'Brazilian Real', 'symbol' => 'R$'],
            ['code' => 'BSD', 'name' => 'Bahamian Dollar', 'symbol' => 'B$'],
            ['code' => 'BTN', 'name' => 'Bhutanese Ngultrum', 'symbol' => 'Nu.'],
            ['code' => 'BWP', 'name' => 'Botswanan Pula', 'symbol' => 'P'],
            ['code' => 'BYN', 'name' => 'Belarusian Ruble', 'symbol' => 'Br'],
            ['code' => 'BZD', 'name' => 'Belize Dollar', 'symbol' => 'BZ$'],
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'CA$'],
            ['code' => 'CDF', 'name' => 'Congolese Franc', 'symbol' => 'FC'],
            ['code' => 'CHF', 'name' => 'Swiss Franc', 'symbol' => 'CHF'],
            ['code' => 'CLP', 'name' => 'Chilean Peso', 'symbol' => 'CLP$'],
            ['code' => 'CNY', 'name' => 'Chinese Yuan', 'symbol' => '¥'],
            ['code' => 'COP', 'name' => 'Colombian Peso', 'symbol' => 'COL$'],
            ['code' => 'CRC', 'name' => 'Costa Rican Colón', 'symbol' => '₡'],
            ['code' => 'CUP', 'name' => 'Cuban Peso', 'symbol' => '$'],
            ['code' => 'CVE', 'name' => 'Cape Verdean Escudo', 'symbol' => '$'],
            ['code' => 'CZK', 'name' => 'Czech Koruna', 'symbol' => 'Kč'],
            ['code' => 'DJF', 'name' => 'Djiboutian Franc', 'symbol' => 'Fdj'],
            ['code' => 'DKK', 'name' => 'Danish Krone', 'symbol' => 'kr'],
            ['code' => 'DOP', 'name' => 'Dominican Peso', 'symbol' => 'RD$'],
            ['code' => 'DZD', 'name' => 'Algerian Dinar', 'symbol' => 'دج'],
            ['code' => 'EGP', 'name' => 'Egyptian Pound', 'symbol' => '£'],
            ['code' => 'ETB', 'name' => 'Ethiopian Birr', 'symbol' => 'Br'],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'],
            ['code' => 'GBP', 'name' => 'British Pound Sterling', 'symbol' => '£'],
            ['code' => 'GHS', 'name' => 'Ghanaian Cedi', 'symbol' => '₵'],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹'],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥'],
            ['code' => 'KES', 'name' => 'Kenyan Shilling', 'symbol' => 'KSh'],
            ['code' => 'NGN', 'name' => 'Nigerian Naira', 'symbol' => '₦'],
            ['code' => 'USD', 'name' => 'United States Dollar', 'symbol' => '$'],
            ['code' => 'ZAR', 'name' => 'South African Rand', 'symbol' => 'R'],
        ];

        foreach ($currencies as $currency) {
            DB::table('currencies')->updateOrInsert(
                ['code' => $currency['code']], // condition (unique key)
                ['name' => $currency['name'], 'symbol' => $currency['symbol']] // update fields
            );
        }
    }
}
