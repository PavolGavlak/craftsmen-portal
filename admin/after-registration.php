<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/User.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Nepovolený prístup.";
    exit;
}

$database = new Database();
$connection = $database->connectionDB();

$firstName = trim($_POST["first_name"] ?? "");
$secondName = trim($_POST["second_name"] ?? "");
$email = trim($_POST["email"] ?? "");
$businessName = trim($_POST["business_name"] ?? "");
$craftName = trim($_POST["craft_name"] ?? "");
$city = trim($_POST["city"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$facebook = trim($_POST["facebook"] ?? "");
$description = trim($_POST["description"] ?? "");
$password = password_hash($_POST["password"] ?? "", PASSWORD_DEFAULT);
$role = "user";
$status = "pending";

$id = User::createUser(
    $connection,
    $firstName,
    $secondName,
    $email,
    $password,
    $businessName,
    $craftName,
    $city,
    $phone,
    $facebook,
    $description,
    $role,
    $status
);

if (!$id) {
    echo "Používateľa sa nepodarilo pridať.";
    exit;
}

session_regenerate_id(true);

$_SESSION["is_logged_in"] = true;
$_SESSION["logged_in_user_id"] = $id;
$_SESSION["role"] = $role;

Url::redirectUrl("/admin/one-craftsman.php?id=$id");
