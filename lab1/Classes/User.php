<?php
declare(strict_types=1);

namespace Classes;

/**
 * Класс User, описывающий пользователя.
 */
class User
{
    public string $name;
    public string $login;
    private string $password;

    /**
     * Конструктор класса User.
     * @param string $name Имя пользователя.
     * @param string $login Логин пользователя.
     * @param string $password Пароль пользователя.
     */
    public function __construct(string $name, string $login, string $password)
    {
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * Метод, выводящий информацию о пользователе.
     */
    public function showInfo(): void
    {
        echo "Имя: {$this->name}, Логин: {$this->login}<br>";
    }

    /**
     * Деструктор класса User.
     */
    public function __destruct()
    {
        echo "Пользователь {$this->login} удален.<br>";
    }
}
