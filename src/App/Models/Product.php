<?php

namespace App\Models;

use Framework\Model;

use PDO;

class Product extends Model
{

    // protected $table = "product";


    protected function validate(array $data): void
    {
        if (empty($data["name"])) {

            $this->addError("name", "Name is required");
        }
    }

    public function getTotal(): int
    {
        $sql = "SELECT count(*) AS total
                FROM product";

        $conn = $this->database->getConnection();

        $stmt = $conn->query($sql);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return (int) $row["total"];
    }
}
