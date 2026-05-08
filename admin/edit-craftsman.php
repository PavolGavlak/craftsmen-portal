<?php

require "../classes/Database.php";
require "../classes/Url.php";
require "../classes/User.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedin()) {
    die("Nepovolený prístup!");
}

$role = $_SESSION["role"];
$loggedInUserId = (int) $_SESSION["logged_in_user_id"];
$database = new Database();
$connection = $database->connectionDB();

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    die("ID nie je zadané.");
}

$id = (int) $_GET["id"];

if ($role !== "admin" && $id !== $loggedInUserId) {
    die("Nemáte oprávnenie upravovať tento profil.");
}

$oneUser = User::getUser($connection, $id);

if (!$oneUser) {
    die("Používateľ nebol nájdený.");
}

$firstName = $oneUser["first_name"];
$secondName = $oneUser["second_name"];
$email = $oneUser["email"];
$businessName = $oneUser["business_name"] ?? "";
$craftName = $oneUser["craft_name"];
$city = $oneUser["city"];
$phone = $oneUser["phone"];
$facebook = $oneUser["facebook"] ?? "";
$description = $oneUser["description"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $firstName = trim($_POST["first_name"] ?? "");
    $secondName = trim($_POST["second_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $businessName = trim($_POST["business_name"] ?? "");
    $craftName = trim($_POST["craft_name"] ?? "");
    $city = trim($_POST["city"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $facebook = trim($_POST["facebook"] ?? "");
    $description = trim($_POST["description"] ?? "");

    if (User::updateUser(
        $connection,
        $id,
        $firstName,
        $secondName,
        $email,
        $businessName,
        $craftName,
        $city,
        $phone,
        $facebook,
        $description
    )) {
        Url::redirectUrl("/admin/one-craftsman.php?id=$id");
    }
}
?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../css/general.css">
    <link rel="stylesheet" href="../css/header.css">
    <link rel="stylesheet" href="../query/header-query.css">
    <link rel="stylesheet" href="../css/footer.css">
    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="../css/admin-edit-craftsman.css">
    <link rel="stylesheet" href="../query/admin-edit-craftsman-query.css">

    <title>Upraviť údaje</title>
</head>

<body>
    <?php $publicBasePath = "../"; ?>
    <?php require "../assets/header.php"; ?>

    <main>
        <form action="" method="POST">
            <input type="text" name="first_name" placeholder="Krstné meno" required value="<?= htmlspecialchars($firstName) ?>">
            <input type="text" name="second_name" placeholder="Priezvisko" required value="<?= htmlspecialchars($secondName) ?>">
            <input type="email" name="email" placeholder="E-mail" required value="<?= htmlspecialchars($email) ?>">
            <input type="text" name="business_name" placeholder="Obchodný názov" required value="<?= htmlspecialchars($businessName) ?>">
            <input type="text" name="craft_name" placeholder="Remeslo" required value="<?= htmlspecialchars($craftName) ?>">
            <input type="text" name="city" placeholder="Mesto alebo obec" required value="<?= htmlspecialchars($city) ?>">
            <input type="text" name="phone" placeholder="Telefón" value="<?= htmlspecialchars($phone) ?>">
            <input type="text" name="facebook" placeholder="Facebook profil alebo odkaz" value="<?= htmlspecialchars($facebook) ?>">
            <textarea name="description" placeholder="Popis vašej tvorby alebo remesla" required><?= htmlspecialchars($description) ?></textarea>
            <input type="submit" value="Uložiť">
        </form>
    </main>

    <?php require "../assets/footer.php" ?>

    <script src="../JS/header.js"></script>
</body>

</html>
