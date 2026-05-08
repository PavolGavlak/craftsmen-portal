<?php

require "./classes/Database.php";
require "./classes/User.php";

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION["role"]) && $_SESSION["role"] === "admin") {
    header("Location: ./admin/craftsmen.php");
    exit;
}

$database = new Database();
$connection = $database->connectionDB();

$craftsmen = User::getApprovedUsers($connection);
$isAdminCraftsmenList = false;
$profileLinkPattern = "craftsmen/profile.php?id=%d";
$imageBasePath = "./uploads/";

?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/header-query.css">
    <link rel="stylesheet" href="./css/craftsmen-list.css">

    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>
    <title>Všetci remeselníci</title>
</head>

<body>
    <?php require "assets/header.php" ?>

    <main>
        <?php require "assets/craftsmen-list.php"; ?>
    </main>

    <?php require "assets/footer.php" ?>
    <script src="./JS/header.js"></script>
    <script src="./JS/filter.js"></script>
</body>

</html>
