<?php

//require "../assets/url.php";
require "../classes/Url.php";



// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

// Zruší nastavenie všetkých premenných relácie.
$_SESSION = array();

// Ak chcete ukončiť reláciu, odstráňte aj súbor cookie relácie.
// Poznámka: Týmto sa zničí relácia a nielen údaje relácie!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Presmerovanie na uvodnu stranu
Url::redirectUrl("/index.php");
?>
