<?php

namespace App\Libraries;

// 注册树
class Tree
{
    private static $data = [];

    public static function set($key, $value)
    {
        self::$data[$key] = $value;
    }

    public static function get($key) {
        return self::$data[$key];
    }
}
