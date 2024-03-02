<?php
class SessionController
{
    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function setSessionValue($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSessionValue($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function destroySession()
    {
        session_unset();
        session_destroy();
    }
}
