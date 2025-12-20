<?php
echo "<h1>Тестирование транзакций PDO</h1>";

try {
    if (file_exists('news.db')) {
        unlink('news.db');
    }
    
    $db = new PDO('sqlite:news.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $db->beginTransaction();
    
    echo "<p>1. Транзакция начата</p>";
    
    $db->exec("
        CREATE TABLE msgs(
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            title TEXT,
            category INTEGER,
            description TEXT,
            source TEXT,
            datetime INTEGER
        )
    ");
    echo "<p>2. Таблица msgs создана</p>";
    
    $db->exec("
        CREATE TABLE category(
            id INTEGER PRIMARY KEY,
            name TEXT
        )
    ");
    echo "<p>3. Таблица category создана</p>";
    
    // category (правильно)
    $db->exec("INSERT INTO category(id, name) VALUES (1, 'Политика')");
    $db->exec("INSERT INTO category(id, name) VALUES (2, 'Культура')");
    $db->exec("INSERT INTO category(id, name) VALUES (3, 'Спорт')");
    echo "<p>4. Таблица category заполнена</p>";
    
    $db->commit();
    echo "<p style='color: green;'>5. Транзакция успешно завершена!</p>";
    
    $size = filesize('news.db');
    echo "<p>Размер файла news.db: " . $size . " байт</p>";
    
} catch (PDOException $e) {
    if (isset($db) && $db->inTransaction()) {
        $db->rollBack();
        echo "<p style='color: red;'>Транзакция отменена из-за ошибки: " . $e->getMessage() . "</p>";
    }
    
    if (file_exists('news.db')) {
        $size = filesize('news.db');
        echo "<p>Размер файла news.db после rollback: " . $size . " байт</p>";
        if ($size == 0) {
            unlink('news.db');
            echo "<p>Файл news.db (нулевого размера) удален</p>";
        }
    }
}
?>