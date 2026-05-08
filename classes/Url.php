<?php

class Url
{
    private static function getApplicationBasePath(): string
    {
        $scriptName = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"] ?? "/");
        $segments = array_values(array_filter(explode("/", trim($scriptName, "/"))));

        return empty($segments) ? "" : "/" . $segments[0];
    }

    public static function redirectUrl(string $path): void
    {
        $protocol = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off")
            ? "https"
            : "http";

        $normalizedPath = preg_match("~^https?://~i", $path)
            ? $path
            : self::getApplicationBasePath() . "/" . ltrim($path, "/");

        header("Location: {$protocol}://{$_SERVER['HTTP_HOST']}{$normalizedPath}");
        exit;
    }
}
