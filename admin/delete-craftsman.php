<?php

require "../classes/Database.php";
require "../classes/User.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedin()) {
    die("Nepovolený prístup!");
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    $redirect = ($_SESSION["role"] ?? null) === "admin" ? "craftsmen.php" : "../index.php";
    header("Location: " . $redirect);
    exit;
}

$role = $_SESSION["role"] ?? null;
$loggedInUserId = (int) ($_SESSION["logged_in_user_id"] ?? 0);
$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

if (!$id || !in_array($role, ["admin", "user"], true)) {
    $redirect = $role === "admin" ? "craftsmen.php" : "../index.php";
    header("Location: " . $redirect);
    exit;
}

$database = new Database();
$connection = $database->connectionDB();
$user = User::getUser($connection, $id, "id, role");

if (!$user) {
    $redirect = $role === "admin" ? "craftsmen.php" : "../index.php";
    header("Location: " . $redirect);
    exit;
}

if ($role === "admin") {
    if (($user["role"] ?? "") === "admin" || (int) $user["id"] === $loggedInUserId) {
        die("Tento účet nie je možné vymazať.");
    }

    User::deleteUser($connection, $id);
    header("Location: craftsmen.php");
    exit;
}

if ((int) $user["id"] !== $loggedInUserId) {
    die("Nemáte oprávnenie vymazať tento účet.");
}

User::deleteUser($connection, $id);

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), "", time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
}

session_destroy();

header("Location: ../index.php");
exit;
