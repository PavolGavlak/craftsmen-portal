<?php

require "../classes/Database.php";
require "../classes/Auth.php";
require "../classes/Url.php";
require "../classes/Image.php";

session_start();

if (!Auth::isLoggedin()) {
    die("Nepovolený prístup.");
}

$role = $_SESSION["role"];
$loggedInUserId = (int) $_SESSION["logged_in_user_id"];

if ($_SERVER["REQUEST_METHOD"] !== "POST" || !isset($_POST["submit"], $_FILES["image"])) {
    die("Nepovolený prístup.");
}

$userId = isset($_POST["user_id"]) && is_numeric($_POST["user_id"])
    ? (int) $_POST["user_id"]
    : 0;

if ($userId <= 0) {
    die("Používateľ nebol zadaný.");
}

if ($role !== "admin" && $userId !== $loggedInUserId) {
    die("Nemáte oprávnenie nahrávať fotky tomuto používateľovi.");
}

$database = new Database();
$connection = $database->connectionDB();

$imageName = $_FILES["image"]["name"] ?? "";
$imageSize = (int) ($_FILES["image"]["size"] ?? 0);
$imageTmpName = $_FILES["image"]["tmp_name"] ?? "";
$error = (int) ($_FILES["image"]["error"] ?? 0);

if ($error !== 0) {
    Url::redirectUrl("/errors/error-page.php?error_text=Obrazok sa nepodarilo vlozit");
}

if ($imageSize > 9000000) {
    Url::redirectUrl("/errors/error-page.php?error_text=Vas subor je prilis velky");
}

$imageExtension = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));
$allowedExtensions = ["jpg", "jpeg", "png"];

if (!in_array($imageExtension, $allowedExtensions, true)) {
    Url::redirectUrl("/errors/error-page.php?error_text=Koncovka suboru nie je povolena");
}

$newImageName = uniqid("IMG-", true) . "." . $imageExtension;
$uploadDirectory = "../uploads/" . $userId;

if (!file_exists($uploadDirectory)) {
    mkdir($uploadDirectory, 0777, true);
}

$imageUploadPath = $uploadDirectory . "/" . $newImageName;
move_uploaded_file($imageTmpName, $imageUploadPath);

if (Image::insertImage($connection, $userId, $newImageName)) {
    Url::redirectUrl("/admin/photos.php?id=$userId");
}

Url::redirectUrl("/errors/error-page.php?error_text=Obrazok sa nepodarilo vlozit");
