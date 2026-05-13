<?php

/**
 * Builds a PDO connection from the local application configuration.
 */
class Database
{
    private array $config;

    public function __construct()
    {
        $appConfig = require __DIR__ . "/../config/app.php";
        $this->config = $appConfig["database"];
    }

    /**
     * Returns a configured PDO connection for the active environment.
     */
    public function connectionDB(): PDO
    {
        $dsn = sprintf(
            "mysql:host=%s;dbname=%s;charset=utf8",
            $this->config["host"],
            $this->config["name"]
        );

        try {
            $connection = new PDO($dsn, $this->config["user"], $this->config["password"]);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            exit;
        }
    }
}
