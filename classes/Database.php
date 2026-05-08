<?php

class Database
{
    private string $dbHost = "localhost";
    private string $dbUser = "pali2";
    private string $dbPassword = "456";
    private string $dbName = "craftsmen";

    public function connectionDB(): PDO
    {
        $dsn = "mysql:host={$this->dbHost};dbname={$this->dbName};charset=utf8";

        try {
            $connection = new PDO($dsn, $this->dbUser, $this->dbPassword);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch (PDOException $exception) {
            echo $exception->getMessage();
            exit;
        }
    }
}
