<?php

/**
 * Redirect helper that works both in a localhost subfolder and in a hosting root.
 */
class Url
{
    /**
     * Detects the application base path from the current script path.
     */
    private static function getApplicationBasePath(): string
    {
        $scriptName = str_replace("\\", "/", $_SERVER["SCRIPT_NAME"] ?? "/");
        $segments = array_values(array_filter(explode("/", trim($scriptName, "/"))));

        if (empty($segments)) {
            return "";
        }

        $firstSegment = $segments[0];
        $internalDirectories = [
            "admin",
            "assets",
            "classes",
            "config",
            "craftsmen",
            "css",
            "errors",
            "img",
            "JS",
            "query",
            "uploads",
            "vendor",
        ];

        if (str_contains($firstSegment, ".") || in_array($firstSegment, $internalDirectories, true)) {
            return "";
        }

        return "/" . $firstSegment;
    }

    /**
     * Redirects to an absolute URL or to an application-relative path.
     */
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