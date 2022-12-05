<?php
namespace App;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class Database
{
    private Connection $connection;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => $_ENV["dbname"],
            'user' => $_ENV["user"],
            'password' => $_ENV["password"],
            'host' => $_ENV["host"],
            'driver' => $_ENV["driver"],
        ];

        $this->connection = DriverManager::getConnection($connectionParams);
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }
}