<?php
require_once 'CProducts.php';

$db = new CProducts('localhost', 'root', '', 'shop');

$rowsToShow = isset($_GET['rows']) ? $_GET['rows'] : 0;

$errors = [];
$notes = [];
if (!filter_var($rowsToShow, FILTER_VALIDATE_INT) && $rowsToShow !== '0') {
    $errors[] = 'Количество строк должно быть целым числом.';    
} elseif ($rowsToShow < 0) {
    $errors[] = 'Количество строк не может быть отрицательным.';
}

if (empty($errors)) {
    $products = $db->getProducts($rowsToShow != 0 ? $rowsToShow : null); // Получаем товары
    $totalProducts = count($products);
    if ($rowsToShow > 0 && $rowsToShow > $totalProducts) {
        $notes[] = 'Запрашиваемое количество строк превышает количество доступных товаров. Выведены все товары.';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Oswald&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto+Slab:wght@100..900&display=swap');
    </style>
</head>
<body>
    <div class="left-block">
        <h3>Выберите действие</h3>
        <button id="restore-products" style="margin-top: 20px;">Показать все скрытые товары</button>
        <form method="get" action="">
            <label for="rows">Количество строк на вывод:</label>
            <input type="number" id="rows" name="rows" min="1" value="<?= htmlspecialchars($rowsToShow) ?>">
            <button type="submit">Применить</button>
        </form>
        <form method="get" action="">
            <button type="submit" name="rows" value="0">Показать все данные</button>
        </form>
        <?php if (!empty($errors)) { ?>
            <?php foreach ($errors as $error) { ?>
                <p style="color: red;"><?= $error ?></p>
            <?php } ?>
        <?php } elseif (!empty($notes)) { ?>
            <?php foreach ($notes as $note) { ?>
                <p style="color: lightgreen;"><?= $note ?></p>
            <?php } ?>
        <?php } ?>
    </div>
    <div class="right-block">
        <h1>Продукты</h1>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Product ID</th>
                        <th>Название</th>
                        <th>Цена</th>
                        <th>Артикул</th>
                        <th>Количество</th>
                        <th>Дата создания</th>
                        <th>Действие</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (isset($products) && !empty($products)) { ?>
                        <?php foreach ($products as $product) { ?>
                            <tr data-id="<?= $product['ID'] ?>" class="<?= $product['hidden'] ? 'hidden' : '' ?>" style="<?= $product['hidden'] ? 'display: none;' : '' ?>">
                                <td><?= $product['ID'] ?></td>
                                <td><?= $product['PRODUCT_ID'] ?></td>
                                <td><?= htmlspecialchars($product['PRODUCT_NAME']) ?></td>
                                <td>$<?= $product['PRODUCT_PRICE'] ?></td>
                                <td><?= htmlspecialchars($product['PRODUCT_ARTICLE']) ?></td>
                                <td>
                                    <div class="quantity-block">
                                        <button class="quantity-decrease">-</button>
                                        <span class="product-quantity"><?= $product['PRODUCT_QUANTITY'] ?></span>
                                        <button class="quantity-increase">+</button>
                                    </div>
                                </td>
                                <td><?= $product['DATE_CREATE'] ?></td>
                                <td><button class="hide-button">Скрыть</button></td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <script>
        // Обработчик для кнопки скрытия товара
        $(document).on('click', '.hide-button', function() {
            const row = $(this).closest('tr');
            const productId = row.data('id');
            $.post('validate_values.php', { id: productId }, function(response) {
                if (response.success) {
                    $.post('hide_product.php', { id: productId }, function(response) {
                    if (response.success) {
                        row.hide("fast");  
                        row.addClass('hidden');
                    } else {
                        console.log('Ошибка скрытия товара.');
                    }
                }, 'json');
                } else {
                    console.log('Данные не валидны. ' + response.message);
                }
            }, 'json');
        });

        // Обработчик для кнопки восстановления всех скрытых товаров
        $('#restore-products').click(function() {
            $.post('restore_products.php', function(response) {
                if (response.success) {
                    $('tr.hidden').show("fast").removeClass('hidden');
                } else {
                    console.log('Ошибка восстановления товаров.');
                }
            }, 'json');
        });

        // Обработчики для кнопок изменения количества
        $(document).on('click', '.quantity-increase', function() {
            const row = $(this).closest('tr');
            const productId = row.data('id');
            const quantityElement = row.find('.product-quantity');
            let quantity = parseInt(quantityElement.text());
            $.post('validate_values.php', { id: productId, quantity: quantity }, function(response) {
                if (response.success) {
                    quantity++;
                    quantityElement.text(quantity);
                    
                    $.post('update_quantity.php', { id: productId, quantity: quantity }, function(response) {
                        if (!response.success) {
                            console.log('Ошибка обновления количества.');
                        }
                    }, 'json');
                } else {
                    console.log('Данные не валидны. ' + response.message);
                }
            }, 'json');
        });

        $(document).on('click', '.quantity-decrease', function() {
            const row = $(this).closest('tr');
            const productId = row.data('id');
            const quantityElement = row.find('.product-quantity');
            let quantity = parseInt(quantityElement.text());
            $.post('validate_values.php', { id: productId, quantity: quantity }, function(response) {
                if (response.success) {

                    quantity--;
                    quantityElement.text(quantity);
                    
                    $.post('update_quantity.php', { id: productId, quantity: quantity }, function(response) {
                        if (!response.success) {
                            console.log('Ошибка обновления количества.');
                        }
                    }, 'json');
                } else {
                    console.log('Данные не валидны. ' + response.message);
                }
            }, 'json');
        });
    </script>
</body>
</html>
