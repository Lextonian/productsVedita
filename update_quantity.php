<?php
require_once 'CProducts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['quantity'])) {
    $productId = $_POST['id'];
    $quantity = $_POST['quantity'];

    try {
        $db = new CProducts('localhost', 'root', '', 'shop');
        $result = $db->updateProductQuantity($productId, $quantity);

        echo json_encode(['success' => $result, 'message' => $productId]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>