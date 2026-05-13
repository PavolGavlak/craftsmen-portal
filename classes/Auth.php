<?php

/**
 * Small authentication helper used by protected admin pages.
 */
class Auth
{
    /**
     * Returns true when the current session belongs to a logged-in user.
     */
    public static function isLoggedin(): bool
    {
        return isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] === true;
    }
}