<?php

class Auth
{
    public static function isLoggedin(): bool
    {
        return isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] === true;
    }
}
