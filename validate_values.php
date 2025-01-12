<?php
require_once 'CProducts.php';

if (($_SERVER['REQUEST_METHOD'] === 'POST') && (isset($_POST['id']))  || (isset($_POST['id']) && isset($_POST['quantity']))) {
    $productId = $_POST['id'];
    $quantity = $_POST['quantity'];

    try {
        $db = new CProducts('localhost', 'root', '', 'shop');
        list($result, $message) = $db->validateProductId($productId); 
        if (!empty($quantity)) {
            list($QuantityResult, $QuantityMessage) = $db->validateProductQuantity($quantity);
            $result = $result && $QuantityResult;
            file_put_contents("umitest", print_r([__FILE__.' '.__LINE__, gettype($QuantityMessage)], true).PHP_EOL, FILE_APPEND | LOCK_EX);
            $message = ($message . " " . $QuantityMessage);
        }
        echo json_encode(['success' => $result, 'message' => $message], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Неверный запрос']);
}
?>
