<?php
declare(strict_types=1);

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

class SuperUser extends User implements SuperUserInterface
{
    public string $role;
    
    // Статическое свойство для подсчета экземпляров SuperUser
    public static int $counter = 0;

    public function __construct(string $name, string $login, string $password, string $role)
    {
        // Сначала отмечаем как SuperUser
        $this->markAsSuperUser();
        
        // Затем вызываем родительский конструктор
        parent::__construct($name, $login, $password);
        
        $this->role = $role;
        
        // Увеличиваем счетчик SuperUser
        self::$counter++;
    }

    public function showInfo(): void
    {
        parent::showInfo();
        echo "Роль: {$this->role}<br>";
    }

    public function getInfo(): string
    {
        return "SuperUser: {$this->name}, Role: {$this->role}";
    }
}