<h1>Все продукты</h1>
<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Цена</th>
        <th>Количество</th>
        <th>Категория</th>
        <th>Стоимость</th>
    </tr>
    <?php foreach ($products as $id => $product): ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $product['name'] ?></td>
        <td><?= $product['price'] ?>$</td>
        <td><?= $product['quantity'] ?></td>
        <td><?= $product['category'] ?></td>
        <td><?= $product['price'] * $product['quantity'] ?>$</td>
    </tr>
    <?php endforeach; ?>
</table>