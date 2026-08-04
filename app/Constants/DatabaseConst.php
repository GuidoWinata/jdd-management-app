<?php

namespace App\Constants;

class DatabaseConst
{
    const SQL_READ = 'mysql_read';

    public static function USER(): string
    {
        return self::DB_CORE().'.users';
    }

    public static function SIDEBAR_MENU(): string
    {
        return self::DB_CORE().'.sidebar_menus';
    }

    public static function SIDEBAR_MENU_ACCESS(): string
    {
        return self::DB_CORE().'.sidebar_menu_accesses';
    }

    public static function SIDEBAR_MENU_GROUP(): string
    {
        return self::DB_CORE().'.sidebar_menu_groups';
    }

    public static function EVENT(): string
    {
        return self::DB_CORE().'.events';
    }

    public static function EVENT_SECTION(): string
    {
        return self::DB_CORE().'.event_sections';
    }

    public static function SPEAKER(): string
    {
        return self::DB_CORE().'.speakers';
    }

    public static function MATERIAL(): string
    {
        return self::DB_CORE().'.materials';
    }

    public static function MATERIAL_SPEAKER(): string
    {
        return self::DB_CORE().'.material_speakers';
    }

    public static function AGENDA_ITEM(): string
    {
        return self::DB_CORE().'.agenda_items';
    }

    public static function MERCHANDISE(): string
    {
        return self::DB_CORE().'.merchandises';
    }

    public static function TICKET(): string
    {
        return self::DB_CORE().'.tickets';
    }

    public static function TICKET_MERCHANDISE(): string
    {
        return self::DB_CORE().'.ticket_merchandises';
    }

    public static function PARTNER(): string
    {
        return self::DB_CORE().'.partners';
    }

    public static function DB_CORE(): string
    {
        return config('database.connections.mysql.database', 'db_nibs');
    }
}
