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
}
