<?php require_once "assets/contact-form-handler.php"; ?>

<!DOCTYPE html>
<html lang="sk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="./css/general.css">
    <link rel="stylesheet" href="./css/header.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link rel="stylesheet" href="./query/header-query.css">
    <link rel="stylesheet" href="./css/contact.css">
    <link rel="stylesheet" href="./css/contact-section.css">

    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>

    <title>Kontakt</title>
</head>

<body>
    <?php require "assets/header.php" ?>

    <main>
        <?php
        $contact_section_class = "contact-page-section";
        $contact_form_action = "contact.php";

        require "assets/contact-form-section.php";
        ?>
    </main>

    <?php require "assets/footer.php" ?>
    <script src="./JS/header.js"></script>
</body>

</html>
