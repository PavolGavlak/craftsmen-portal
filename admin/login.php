<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/User.php";

session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $database = new Database();
    $connection = $database->connectionDB();

    $loginEmail = trim($_POST["login-email"] ?? "");
    $loginPassword = $_POST["login-password"] ?? "";

    if (User::autentication($connection, $loginEmail, $loginPassword)) {
        $id = User::getUserId($connection, $loginEmail);
        $role = $id !== null ? User::getUseRole($connection, $id) : null;

        if ($id !== null && $role !== null) {
            session_regenerate_id(true);

            $_SESSION["is_logged_in"] = true;
            $_SESSION["logged_in_user_id"] = $id;
            $_SESSION["role"] = $role;

            if ($role === "admin") {
                Url::redirectUrl("/admin/craftsmen.php");
            }

            Url::redirectUrl("/admin/one-craftsman.php?id=$id");
        }
    }

    $error = "Chyba pri prihlásení.";
}

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prihlásenie</title>
</head>

<body>
    <?php if ($error !== ""): ?>
        <p><?= htmlspecialchars($error) ?></p>
        <a href="../signin.php">Späť na prihlásenie</a>
    <?php endif; ?>
</body>

</html>
