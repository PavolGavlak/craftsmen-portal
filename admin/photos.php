<?php
require "../classes/Database.php";
require "../classes/Auth.php";
require "../classes/User.php";
require "../classes/Image.php";

session_start();

if (!Auth::isLoggedin()) {
    die("Nepovolený prístup.");
}

$role = $_SESSION["role"];
$logged_in_user_id = (int) $_SESSION["logged_in_user_id"];

if ($role === "admin" && isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $user_id = (int) $_GET["id"];
} elseif ($role === "admin") {
    die("Admin musí otvoriť fotky cez konkrétny profil používateľa.");
} else {
    $user_id = $logged_in_user_id;
}

$db = new Database();
$connection = $db->connectionDB();

$profileUser = User::getUser($connection, $user_id);

if (!$profileUser) {
    die("Používateľ nebol nájdený.");
}

$allImages = Image::getImagesByUserId($connection, $user_id);

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
    <link rel="stylesheet" href="../css/admin-photos.css">
    <title>Fotky</title>
</head>

<body>
    <?php $publicBasePath = "../"; ?>
    <?php require "../assets/header.php"; ?>

    <main>
        <section class="upload-photos">
            <h1>Fotky</h1>
            <p><?= htmlspecialchars($profileUser["first_name"]) . " " . htmlspecialchars($profileUser["second_name"]) ?></p>
            <form action="upload-photos.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                <label for="choose-file" id="choose-file-text">Vybrať obrázok</label>
                <input type="file" id="choose-file" name="image" required>

                <input type="submit" class="upload-file" name="submit" value="Nahrať obrázok">
            </form>
        </section>

        <section class="images">
            <?php if (empty($allImages)): ?>
                <p class="no-photos-message">Zatiaľ nie sú nahraté žiadne fotky.</p>
            <?php else: ?>
                <article>
                    <?php foreach ($allImages as $one_image): ?>
                        <div class="image-card">
                            <div>
                                <img src="<?= "../uploads/" . $user_id . "/" . $one_image["file_name"] ?>" alt="">
                            </div>
                            <?php if (!empty($one_image["is_profile"])): ?>
                                <p class="profile-badge">Profilová fotka</p>
                            <?php endif; ?>
                            <div class="images-btn">
                                <?php if (empty($one_image["is_profile"])): ?>
                                    <a class="images-btn-profile" href="<?= "set-profile-photo.php?id=" . $user_id . "&image_id=" . $one_image["id"] ?>">Nastaviť ako profilovú fotku</a>
                                <?php endif; ?>
                                <a class="images-btn-download" href="<?= "../uploads/" . $user_id . "/" . $one_image["file_name"] ?>" download="stiahnuty-subor">Stiahnuť</a>
                                <a class="images-btn-delete" href="<?= "delete-photo.php?id=" . $user_id . "&image_name=" . $one_image["file_name"] ?>">Zmazať</a>
                            </div>
                        </div>
                    <?php endforeach ?>
                </article>
            <?php endif; ?>
        </section>

        <div class="photos-back-link">
            <a href="one-craftsman.php?id=<?= $user_id ?>">Späť na profil</a>
        </div>
    </main>

    <?php require "../assets/footer.php" ?>
    <script src="../JS/header.js"></script>
</body>

</html>

