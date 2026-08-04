<?php

namespace App\Constants;

class UserConst
{
    const SUPERADMIN = 1;

    const EVENT = 2;

    const TICKETING = 3;

    const DEFAULT_PASSWORD = 'asdasd';

    public static function getAccessTypes(): array
    {
        return [
            self::SUPERADMIN => 'Super Admin',
            self::EVENT => 'Event',
            self::TICKETING => 'Ticketing',
        ];
    }

    public static function getAppAccessTypes(): array
    {
        return self::getAccessTypes();
    }
}
