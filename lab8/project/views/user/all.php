<h1>Все пользователи</h1>
<ul>
    <?php foreach ($users as $id => $user): ?>
    <li>
        <strong>#<?= $id ?>: <?= $user['name'] ?></strong><br>
        Возраст: <?= $user['age'] ?>, Зарплата: <?= $user['salary'] ?>
    </li>
    <?php endforeach; ?>
</ul>