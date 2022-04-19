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
            'SASO Department'
        ];
    }
}
