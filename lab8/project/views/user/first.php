<h1>Первые <?= $n ?> пользователей</h1>
<ul>
    <?php for ($i = 1; $i <= $n; $i++): ?>
        <?php if (isset($users[$i])): ?>
        <li>
            <strong>#<?= $i ?>: <?= $users[$i]['name'] ?></strong><br>
            Возраст: <?= $users[$i]['age'] ?>
        </li>
        <?php endif; ?>
    <?php endfor; ?>
</ul>