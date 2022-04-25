<?php

namespace App\Constants;

class LocationConstant
{
    public const DEFAULT = 'Inside the school.';
    public const OUT = 'Outside the school.';
    public static function locations(): array
    {
        return [
            'IT Department',
            'Education Department',
            'Entrepreneur Department',
            'Fishery Department',
            'Admin Office',
            'SASO Office',
            'Accounting',
            'Registrar',
            'Cashier',
            'HRMO',
            'CMDC',
            'Library',
            'Clinic'
        ];
    }
}
