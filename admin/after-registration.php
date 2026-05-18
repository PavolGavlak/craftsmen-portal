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

// Re-read the new account from the database so the post-registration
// session uses the same identity data as the regular login flow.
$registeredUserId = User::getUserId($connection, $email);
$registeredUserRole = $registeredUserId !== null
    ? User::getUseRole($connection, $registeredUserId)
    : null;

if ($registeredUserId === null || $registeredUserRole === null) {
    echo "Používateľa sa nepodarilo prihlásiť po registrácii.";
    exit;
}

session_regenerate_id(true);

$_SESSION["is_logged_in"] = true;
$_SESSION["logged_in_user_id"] = $registeredUserId;
$_SESSION["role"] = $registeredUserRole;

// Persist the session before redirecting to avoid landing on the public
// profile without management controls on the first request after signup.
session_write_close();

Url::redirectUrl("/admin/one-craftsman.php?id=$registeredUserId");
