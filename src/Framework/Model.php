<?php

namespace Framework;

use PDO;

use App\Database;

abstract class Model
{

    protected $table;

    private function getTable(): string
    {
        if ($this->table !== null) {
            return $this->table;
        }

        $parts = explode("\\", $this::class);
        return strtolower(array_pop($parts));
    }
    public function __construct(private Database $database)
    {
    }
    public function findAll(): array
    {

        $pdo = $this->database->getConnection();

        $sql = "SELECT *
                FROM {$this->table}";

        $stmt = $pdo->query("SELECT * FROM {$this->getTable()}");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find(string $id): array|bool
    {
        $conn = $this->database->getConnection();
        $sql = "SELECT *
                FROM {$this->getTable()}
                WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert(array $data): bool
    {
        $sql = "INSERT INTO product (name, description)
                VALUES (?,?)";

        $conn = $this->database->getConnection();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(1, $data["name"], PDO::PARAM_STR);
        $stmt->bindValue(2, $data["description"], PDO::PARAM_STR);

        return $stmt->execute();
    }
}
