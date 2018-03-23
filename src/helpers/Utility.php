<?php

namespace App\helpers;

/**
 * Class Utility
 * @package App\helpers
 */
class Utility
{
    /**
     * @return bool
     */
    public static function isAppEngine()
    {
        return (isset($_SERVER['SERVER_SOFTWARE']) &&
            strpos($_SERVER['SERVER_SOFTWARE'], 'Google App Engine') !== false);
    }

    /**
     * @return string
     */
    public static function baseURL()
    {
        $protocol = 'http://';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $protocol  = "https://";
        }
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . $host;
    }
}
