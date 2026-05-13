<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// The same header is reused from root pages and nested directories.
$publicBasePath = $publicBasePath ?? "./";
$currentScript = basename($_SERVER["SCRIPT_NAME"] ?? "");
$roleForHeader = $_SESSION["role"] ?? null;
$loggedInUserId = $_SESSION["logged_in_user_id"] ?? null;

$newsLink = $currentScript === "index.php"
    ? "#aktuality"
    : $publicBasePath . "index.php#aktuality";
$articlesLink = $publicBasePath . "articles.php";
$contactLink = $currentScript === "index.php"
    ? "#kontakt"
    : $publicBasePath . "index.php#kontakt";
$craftsmenLink = $roleForHeader === "admin"
    ? $publicBasePath . "admin/craftsmen.php"
    : $publicBasePath . "all-craftsmen.php";
$logoutLink = $publicBasePath . "admin/logout.php";
$accountLink = null;

if ($roleForHeader === "user" && $loggedInUserId !== null) {
    $accountLink = $publicBasePath . "admin/one-craftsman.php?id=" . $loggedInUserId;
}
?>

<header>
    <div class="logo">
        <a href="<?= $publicBasePath ?>index.php">
            <img src="<?= $publicBasePath ?>img/logo-lite.png" alt="Cech logo">
        </a>
    </div>

    <nav>
        <ul>
            <li><a href="<?= $publicBasePath ?>index.php">Domov</a></li>
            <li><a href="<?= $newsLink ?>">Aktuality</a></li>
            <li><a href="<?= $articlesLink ?>">Články</a></li>
            <li><a href="<?= $craftsmenLink ?>">Remeselníci</a></li>
            <li><a href="<?= $contactLink ?>">Kontakt</a></li>

            <?php if ($accountLink !== null): ?>
                <li><a href="<?= $accountLink ?>">Môj profil</a></li>
            <?php endif; ?>

            <?php if ($roleForHeader !== null): ?>
                <li><a href="<?= $logoutLink ?>">Odhlásiť</a></li>
            <?php else: ?>
                <li><a href="<?= $publicBasePath ?>registration-form.php">Registrácia</a></li>
                <li><a href="<?= $publicBasePath ?>signin.php">Prihlásenie</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="menu-icon">
        <i class="fa-solid fa-bars"></i>
    </div>
</header>