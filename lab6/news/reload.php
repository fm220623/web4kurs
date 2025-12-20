<?php
// Восстановление оригинального файла
$sourceFile = 'NewsDB.class.php';
$backupFile = 'NewsDB.class.php.backup';

if (file_exists($backupFile)) {
    if (copy($backupFile, $sourceFile)) {
        echo "Оригинальный файл NewsDB.class.php восстановлен<br>";
    } else {
        echo "Ошибка при восстановлении файла";
    }
} else {
    echo "Резервная копия не найдена";
}

// Удаляем news.db чтобы проверить создание новой БД
if (file_exists('news.db')) {
    unlink('news.db');
    echo "<br>Файл news.db удален для тестирования";
}

echo "<br><a href='news.php'>Проверить работу</a>";
?>