<?php
$sourceFile = 'NewsDB.class.php';
$backupFile = 'NewsDB.class.php.backup';

if (!file_exists($backupFile)) {
    copy($sourceFile, $backupFile);
}

// Читаем содержимое файла
$content = file_get_contents($sourceFile);

// Вносим ошибку
$content = str_replace(
    "INSERT INTO category(id, name) VALUES (1, 'Политика')",
    "INSERT INTO category_error(id, name) VALUES (1, 'Политика')",
    $content
);

file_put_contents($sourceFile, $content);

echo "Файл NewsDB.class.php испорчен (таблица category_error не существует)<br>";
echo "<a href='news.php'>Проверить работу с ошибкой</a><br>";
echo "<a href='reload.php'>Восстановить оригинальный файл</a>";
?>