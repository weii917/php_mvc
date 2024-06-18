<?php

namespace App;

use PDO;

class Database
{
    private ?PDO $pdo = null;

    public function __construct(
        private string|int $host,
        private string $name,
        private string $user,
        private string $password
    ) {
        // echo "Created Database object";
    }
    public function getConnection(): PDO
    {
        if ($this->pdo === null) {
            $dsn = "mysql:host=localhost;dbname=product_db;charset=utf8;port=3306";
            $this->pdo = new PDO($dsn, "product_db_user", "secret", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        }

        return $this->pdo;
    }
}
