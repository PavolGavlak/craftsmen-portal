<?php

require "../classes/Database.php";
require "../classes/User.php";
require "../classes/Auth.php";

session_start();

if (!Auth::isLoggedin()) {
    die("Nepovolený prístup!");
}

if ($_SESSION["role"] !== "admin") {
    die("Obsah stránky je k dispozícii iba administrátorom.");
}

$database = new Database();
$connection = $database->connectionDB();

$craftsmen = User::getAllUsers($connection);
$isAdminCraftsmenList = true;
$profileLinkPattern = "one-craftsman.php?id=%d";
$imageBasePath = "../uploads/";

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
    <link rel="stylesheet" href="../css/craftsmen-list.css">

    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>
    <title>Zoznam členov</title>
</head>

<body>
    <?php $publicBasePath = "../"; ?>
    <?php require "../assets/header.php"; ?>

    <main>
        <?php require "../assets/craftsmen-list.php"; ?>
    </main>

    <?php require "../assets/footer.php" ?>

    <script src="../JS/header.js"></script>
    <script src="../JS/filter.js"></script>
</body>

</html>
