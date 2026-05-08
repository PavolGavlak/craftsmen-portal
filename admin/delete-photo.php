<?php

require "../classes/Database.php";
require "../classes/Auth.php";
require "../classes/Image.php";
require "../classes/Url.php";

session_start();

if (!Auth::isLoggedin()) {
    die("Nepovolený prístup.");
}

$userId = (int) ($_GET["id"] ?? 0);
$imageName = $_GET["image_name"] ?? "";
$loggedInUserId = (int) $_SESSION["logged_in_user_id"];
$role = $_SESSION["role"];

if ($userId <= 0 || $imageName === "") {
    die("Neplatné údaje.");
}

if ($role !== "admin" && $userId !== $loggedInUserId) {
    die("Nemáte oprávnenie mazať túto fotku.");
}

$database = new Database();
$connection = $database->connectionDB();
$imagePath = "../uploads/" . $userId . "/" . $imageName;

if (Image::deletePhotoFromDirectory($imagePath)) {
    Image::deletePhotoFromDatabase($connection, $imageName, $userId);
}

Url::redirectUrl("/admin/photos.php?id=$userId");
