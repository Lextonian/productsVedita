<?php
class CProducts {
    private $pdo;

    public function __construct($host, $user, $password, $database) {
        $dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Ошибка подключения: " . $e->getMessage());
        }
    }

    public function getProducts($limit) {
        $sql = "SELECT * FROM Products ORDER BY DATE_CREATE DESC";
        if ($limit != 0) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $this->pdo->prepare($sql);
        if ($limit != 0) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function hideProduct($productId) {
        $sql = "UPDATE Products SET hidden = 1 WHERE ID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $productId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            error_log('Ошибка при обновлении записи: ' . implode(', ', $stmt->errorInfo()));
            return false;
        }
    }

    public function restoreHiddenProducts() {
        $sql = "UPDATE Products SET hidden = 0 WHERE hidden = 1";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    public function updateProductQuantity($productId, $quantity) {
        $sql = "UPDATE Products SET PRODUCT_QUANTITY = :quantity WHERE ID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":quantity", $quantity, PDO::PARAM_INT);
        $stmt->bindValue(":id", $productId, PDO::PARAM_INT);
        return $stmt->execute();
    }
    public function validateProductId($productId) {
        $errors = "";
        if (!filter_var($productId, FILTER_VALIDATE_INT)) {
            $errors = "ID продукта должен быть целым числом.";
        } elseif ((int)$productId <= 0) {
            $errors = "ID продукта должен быть больше 0.";
        }

        if (empty($errors)) {
            $productId = intval($productId);
            $sql = "SELECT COUNT(*) FROM Products WHERE ID = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(":id", $productId, PDO::PARAM_INT);
            $stmt->execute();
            if ($stmt->fetchColumn() == 0) {
                $errors = "Продукт с ID $productId не найден.";
            }
        }

        if (!empty($errors)) {
            return [false, $errors];
        }
        return [true, "ID валидно."];
    }


    public function validateProductQuantity($quantity) {
        $errors = [];
        if (!filter_var($quantity, FILTER_VALIDATE_INT)) {
            $errors = "Количество должно быть целым числом.";
        } elseif ((int)$quantity <= 0) {
            $errors = "Количество должно быть больше 0.";
        }

        if (empty($errors)) {
            return [true, "Количество валидно."];
        }
        return [false, $errors];
    }
}
?>
