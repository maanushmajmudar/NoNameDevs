<?php
class cookiesController
{
    public static function setCookie($key, $value)
    {
        setcookie($key, $value, time() + 3000, '/');
    }

    public static function deleteCookie($key)
    {
        setcookie($key, '', time() - 3000, '/');
    }
}
