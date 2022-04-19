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
    const INSTRUCTOR1 = 'instructor_1';
    const INSTRUCTOR2 = 'instructor_2';
    const ASSOCIATEPROF1 = 'associate_prof_1';
    const ASSOCIATEPROF2 = 'associate_prof_2';
    const ASSOCIATEPROF3 = 'associate_prof_3';
    const ASSOCIATEPROF4 = 'associate_prof_1';
    const ASSISTANT1 = 'assistant_prof_1';
    public static function positions(): array
    {
        return [
            self::INSTRUCTOR1,
            self::INSTRUCTOR2,
            self::ASSOCIATEPROF1,
            self::ASSOCIATEPROF2,
            self::ASSOCIATEPROF3,
            self::ASSOCIATEPROF4,
            self::ASSISTANT1,
        ];
    }

    const DEFAULT_DEPARTMENT = 'IT Department';
}
