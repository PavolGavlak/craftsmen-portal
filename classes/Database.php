<?php

class Database
{
    private array $config;

    public function __construct()
    {
        $appConfig = require __DIR__ . "/../config/app.php";
        $this->config = $appConfig["database"];
    }

    public function connectionDB(): PDO
    {
        $dsn = "mysql:host={$this->config['host']};dbname={$this->config['name']};charset=utf8";

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
