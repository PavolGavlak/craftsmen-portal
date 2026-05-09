<?php

require "../classes/Database.php";
require "../classes/User.php";
require "../classes/Auth.php";
require "../classes/Image.php";

session_start();

if (!Auth::isLoggedin()) {
    die("Nepovolený prístup!");
}

$role = $_SESSION["role"];
$loggedInUserId = (int) $_SESSION["logged_in_user_id"];
$database = new Database();
$connection = $database->connectionDB();

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $userId = (int) $_GET["id"];

    if ($role !== "admin" && $userId !== $loggedInUserId) {
        die("Nemáte oprávnenie zobraziť tento profil.");
    }

    $craftsman = User::getUser($connection, $userId);
    $allImages = Image::getImagesByUserId($connection, $userId);
    $profileImage = Image::getProfileImageByUserId($connection, $userId);
    $galleryImages = $profileImage
        ? array_values(array_filter($allImages, fn($image) => (int) $image["id"] !== (int) $profileImage["id"]))
        : $allImages;
} else {
    $craftsman = null;
    $allImages = [];
    $profileImage = null;
    $galleryImages = [];
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
    <link rel="stylesheet" href="../css/one-craftsman.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css">

    <script src="https://kit.fontawesome.com/1da98e69a2.js" crossorigin="anonymous"></script>

    <title>Profil člena</title>
</head>

<body>
    <?php $publicBasePath = "../"; ?>
    <?php require "../assets/header.php"; ?>

    <main>
        <section class="one-craftsman">
            <?php if ($craftsman === null): ?>
                <p>Člen nebol nájdený.</p>
            <?php else: ?>
                <div class="one-craftsman-box">
                    <div class="profile-summary">
                        <div class="profile-image-wrap">
                            <?php if ($profileImage): ?>
                                <img
                                    class="profile-image"
                                    src="<?= "../uploads/" . $craftsman["id"] . "/" . $profileImage["file_name"] ?>"
                                    alt=""
                                >
                            <?php else: ?>
                                <div class="profile-image placeholder">
                                    <span><?= strtoupper(substr($craftsman["first_name"], 0, 1)) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="profile-main-info">
                            <div class="profile-name-row">
                                <?php if ($role === "admin" || $loggedInUserId === (int) $craftsman["id"]): ?>
                                    <a class="edit-one-craftsman" href="edit-craftsman.php?id=<?= $craftsman["id"] ?>">
                                        Upraviť údaje
                                    </a>
                                <?php endif; ?>
                            </div>

                            <h2>
                                <?= htmlspecialchars($craftsman["first_name"]) . " " . htmlspecialchars($craftsman["second_name"]) ?>
                            </h2>
                            <p><span class="profile-label">Zameranie:</span> <?= htmlspecialchars(($craftsman["business_name"] ?? "") !== "" ? $craftsman["business_name"] : $craftsman["craft_name"]) ?></p>
                            <p><span class="profile-label">Remeslo:</span> <?= htmlspecialchars($craftsman["craft_name"]) ?></p>
                            <p><span class="profile-label">Lokalita:</span> <?= htmlspecialchars($craftsman["city"]) ?></p>
                            <p><span class="profile-label">Telefón:</span> <?= htmlspecialchars($craftsman["phone"] ?: "-") ?></p>
                            <p><span class="profile-label">E-mail:</span> <?= htmlspecialchars($craftsman["email"] ?: "-") ?></p>
                            <p>
                                <span class="profile-label">Facebook:</span>
                                <?php if (!empty($craftsman["facebook"])): ?>
                                    <?php $facebookUrl = preg_match("~^https?://~i", $craftsman["facebook"]) ? $craftsman["facebook"] : "https://" . $craftsman["facebook"]; ?>
                                    <a href="<?= htmlspecialchars($facebookUrl) ?>" target="_blank" rel="noopener noreferrer">
                                        <?= htmlspecialchars($craftsman["facebook"]) ?>
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                            <p><span class="profile-label">Stav člena:</span> <?= htmlspecialchars($craftsman["status"]) ?></p>
                        </div>
                    </div>

                    <div class="profile-description">
                        <p><?= nl2br(htmlspecialchars($craftsman["description"] ?: "")) ?></p>
                    </div>

                    <section class="profile-photos">
                        <div class="one-craftsman-buttons">
                            <?php if ($role === "admin"): ?>
                                <a class="edit-one-craftsman" href="craftsmen.php">Späť na zoznam</a>
                            <?php endif; ?>

                            <?php if ($role === "admin" || $loggedInUserId === (int) $craftsman["id"]): ?>
                                <a class="edit-one-craftsman" href="photos.php?id=<?= $craftsman["id"] ?>">
                                    Spravovať fotky
                                </a>
                            <?php endif; ?>

                            <?php if ($role === "admin" && (int) $craftsman["id"] !== $loggedInUserId): ?>
                                <form
                                    class="delete-craftsman-form"
                                    action="delete-craftsman.php"
                                    method="POST"
                                    onsubmit="return confirm('Naozaj chcete vymazať tohto používateľa?');"
                                >
                                    <input type="hidden" name="id" value="<?= $craftsman["id"] ?>">
                                    <button class="delete-one-craftsman" type="submit">Vymazať používateľa</button>
                                </form>
                            <?php endif; ?>

                            <?php if ($role === "user" && (int) $craftsman["id"] === $loggedInUserId): ?>
                                <form
                                    class="delete-craftsman-form"
                                    action="delete-craftsman.php"
                                    method="POST"
                                    onsubmit="return confirm('Naozaj chcete vymazať svoj účet?');"
                                >
                                    <input type="hidden" name="id" value="<?= $craftsman["id"] ?>">
                                    <button class="delete-one-craftsman" type="submit">Vymazať účet</button>
                                </form>
                            <?php endif; ?>
                        </div>

                        <?php if (empty($galleryImages)): ?>
                            <p>Fotky ešte neboli pridané.</p>
                        <?php else: ?>
                            <div class="profile-photos-grid">
                                <?php foreach ($galleryImages as $oneImage): ?>
                                    <?php $imagePath = "../uploads/" . $craftsman["id"] . "/" . $oneImage["file_name"]; ?>
                                    <div class="profile-photo-card">
                                        <a
                                            href="<?= htmlspecialchars($imagePath) ?>"
                                            class="glightbox"
                                            data-gallery="craftsman-gallery-<?= $craftsman["id"] ?>"
                                            data-title="<?= htmlspecialchars($craftsman["first_name"] . " " . $craftsman["second_name"]) ?>"
                                        >
                                            <img
                                                src="<?= htmlspecialchars($imagePath) ?>"
                                                alt="<?= htmlspecialchars($craftsman["first_name"] . " " . $craftsman["second_name"]) ?>"
                                            >
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </section>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <?php require "../assets/footer.php"; ?>

    <script src="../JS/header.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
    <script src="../JS/glightbox-init.js"></script>
</body>

</html>

