<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$scriptPath = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"] ?? "");
$footerBasePath = $footerBasePath
    ?? ((str_contains($scriptPath, "/admin/") || str_contains($scriptPath, "/craftsmen/")) ? "../" : "./");
$footerRole = $_SESSION["role"] ?? null;
$footerCraftsmenLink = $footerRole === "admin"
    ? $footerBasePath . "admin/craftsmen.php"
    : $footerBasePath . "all-craftsmen.php";
?>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-brand">
            <h3>Cech remeselníkov Žilinského kraja</h3>
            <p>Podporujeme poctivú ručnú prácu, tradičné remeslá a lokálnych tvorcov.</p>
        </div>

        <div class="footer-links">
            <h4>Základné odkazy</h4>
            <ul>
                <li><a href="<?= $footerBasePath ?>index.php">Domov</a></li>
                <li><a href="<?= $footerCraftsmenLink ?>">Remeselníci</a></li>
                <li><a href="<?= $footerBasePath ?>articles.php">Články</a></li>
                <li><a href="<?= $footerBasePath ?>index.php#kontakt">Kontakt</a></li>
            </ul>
        </div>

        <div class="footer-contact">
            <h4>Kontaktné údaje</h4>
            <p>Cech remeselníkov Žilinského kraja</p>
            <p>Hlavná 125</p>
            <p>010 01 Žilina</p>
            <p>E-mail: <a href="mailto:info@cechremeselnikov.sk">info@cechremeselnikov.sk</a></p>
            <p>Telefón: <a href="tel:+421905123456">+421 905 123 456</a></p>
        </div>
    </div>

    <p class="footer-copy">&copy; <?= date("Y") ?> Cech remeselníkov Žilinského kraja. Všetky práva vyhradené.</p>
</footer>