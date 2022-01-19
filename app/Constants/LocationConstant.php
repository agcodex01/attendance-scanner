<?php

namespace App\Constants;

class LocationConstant
{
    public const DEFAULT = 'Gate Entrance.';
    public static function locations(): array {
        return [
            'IT Department',
            'Faculty Department'
        ];
    }
}
