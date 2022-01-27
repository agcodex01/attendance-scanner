<?php

namespace App\Constants;


class UserConstant
{

    // User status
    const ACTIVE = 'active';
    const INACTIVE = 'inactive';

    public static function statuses(): array
    {
        return [
            self::ACTIVE,
            self::INACTIVE
        ];
    }

    // User types
    const SUPER_ADMIN = 'super-admin';
    const ADMIN = 'admin';
    const EMPLOYEE = 'employee';

    public static function types(): array
    {
        return [
            self::SUPER_ADMIN,
            self::ADMIN,
            self::EMPLOYEE
        ];
    }

    // User positions
    const IT = 'it';
    const TEACHER = 'teacher';
    const GUARD = 'guard';

    public static function positions(): array
    {
        return [
            self::IT,
            self::TEACHER,
            self::GUARD
        ];
    }

    const DEFAULT_DEPARTMENT = 'IT Department';
}
