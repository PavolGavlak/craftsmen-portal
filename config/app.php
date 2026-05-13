<?php

$localConfigPath = __DIR__ . "/app.local.php";

// Keep environment-specific secrets in a local file that is not committed.
if (!file_exists($localConfigPath)) {
    throw new RuntimeException("Missing local config file: config/app.local.php.");
}

return require $localConfigPath;
