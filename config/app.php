<?php

$localConfigPath = __DIR__ . "/app.local.php";

if (!file_exists($localConfigPath)) {
    throw new RuntimeException("Chýba lokálny konfiguračný súbor config/app.local.php.");
}

return require $localConfigPath;
