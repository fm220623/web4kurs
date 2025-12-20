<?php
if (file_exists('news.db')) {
    if (unlink('news.db')) {
        echo "Файл news.db успешно удален";
    } else {
        echo "Ошибка при удалении news.db";
    }
} else {
    echo "Файл news.db не найден";
}
?>