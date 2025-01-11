<?php
require_once 'CProducts.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $db = new CProducts('localhost', 'root', '', 'shop');
        $result = $db->restoreHiddenProducts();

        echo json_encode(['success' => $result]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
