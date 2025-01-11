<?php
require_once 'CProducts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $productId = (int)$_POST['id'];
    try {
        $db = new CProducts('localhost', 'root', '', 'shop');
        $result = $db->hideProduct($productId);

        echo json_encode(['success' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Неверный запрос']);
}


?>
