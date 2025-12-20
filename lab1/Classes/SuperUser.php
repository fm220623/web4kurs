<?php
declare(strict_types=1);

// Объявление класса User
namespace Classes;

// Регистрируем автозагрузчик для классов
spl_autoload_register(function ($class) {
    // Преобразуем пространство имен и имя класса в путь
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/' . $class . '.php';
    
    // Проверяем, существует ли файл
    if (file_exists($file)) {
        require_once $file;
    }
});

// Объявление класса SuperUser, который наследует User
namespace Classes;

class SuperUser extends User
{
    public string $role;

    public function __construct(string $name, string $login, string $password, string $role)
    {
        parent::__construct($name, $login, $password);
        $this->role = $role;
    }

    public function showInfo(): void
    {
        parent::showInfo();
        echo "Роль: {$this->role}<br>";
    }
}

// Использование классов
$superUser = new SuperUser('Иван', 'ivan123', 'pass123', 'Администратор');
$superUser->showInfo();
