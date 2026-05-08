<?php

require "../classes/Database.php";
require "../classes/Auth.php";
require "../classes/Image.php";
require "../classes/Url.php";

session_start();

if (!Auth::isLoggedin()){
    die("Nepovoleny pristup");
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"]) || !isset($_GET["image_id"]) || !is_numeric($_GET["image_id"])) {
    die("Fotka alebo pouzivatel nebol zadany");
}

$role = $_SESSION["role"];
$logged_in_user_id = (int) $_SESSION["logged_in_user_id"];
$user_id = (int) $_GET["id"];
$image_id = (int) $_GET["image_id"];

if ($role !== "admin" && $user_id !== $logged_in_user_id) {
    die("Nemate opravnenie menit profilovu fotku tomuto pouzivatelovi");
}

$db = new Database();
$connection = $db->connectionDB();

if (Image::setProfileImage($connection, $user_id, $image_id)) {
    Url::redirectUrl("/admin/photos.php?id=$user_id");
}
