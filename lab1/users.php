<?php
declare(strict_types=1);

use Classes\User;
use Classes\SuperUser;

/**
 * Автозагрузка классов.
 */
spl_autoload_register(function (string $className) {
    $path = __DIR__ . '/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

// Создание пользователей
$user1 = new User("Иван Иванов", "ivanov", "pass123");
$user2 = new User("Петр Петров", "petrov", "qwerty");
$user3 = new User("Сидор Сидоров", "sidorov", "123456");
echo "<br>";

// Вызов метода showInfo() для пользователей
$user1->showInfo();
$user2->showInfo();
$user3->showInfo();
echo "<br>";

// Создание суперпользователя
$superUser = new SuperUser("Админ", "admin", "root", "Administrator");
$superUser->showInfo();
$superUser2 = new SuperUser("Иван", "ivan123", "pass123", "Administrator");
$superUser2->showInfo();

// Вывод количества созданных объектов
echo "<br>Всего обычных пользователей: " . User::$counter . "<br>";
echo "Всего супер-пользователей: " . SuperUser::$counter . "<br>";