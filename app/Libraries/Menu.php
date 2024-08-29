<?php

namespace App\Libraries;

class Menu
{
    private static $menu;
    private static $user;

    public static function setMenu($menu)
    {
        self::$menu = $menu;
    }

    public static function getMenu()
    {
        return self::$menu;
    }

    public static function setUser($user)
    {
        self::$user = $user;
    }

    public static function getUser()
    {
        return self::$user;
    }
}
