<?php
namespace Factory\Models;


class Users extends Collection
{
    public function __construct(public ?array $users = null)
    {
        $users ??= [
            new User('Ivan.Ivanov@example.com', 'password', 'Ivan', 'Ivanov'),
            new User('Vasya.Vasyachkin@example.com', 'password', 'Vasya', 'Vasyachkin'),
            new User('Petya.Petyavich@example.com', 'password', 'Petya', 'Petyavich}'),
            new User('soso.sosok@example.com', 'password', 'soso', 'sosok'),
            new User('slop.mrekk@example.com', 'password', 'slop', 'mrekk'),
        ];
        $this->users = $users;
        parent::__construct($users);
    }
}

