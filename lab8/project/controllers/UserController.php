<?php
namespace Project\Controllers;
use \Core\Controller;

class UserController extends Controller
{
    private $users;

    public function __construct()
    {
        $this->users = [
            1 => ['name'=>'user1', 'age'=>'23', 'salary' => 1000],
            2 => ['name'=>'user2', 'age'=>'24', 'salary' => 2000],
            3 => ['name'=>'user3', 'age'=>'25', 'salary' => 3000],
            4 => ['name'=>'user4', 'age'=>'26', 'salary' => 4000],
            5 => ['name'=>'user5', 'age'=>'27', 'salary' => 5000],
        ];
    }

    public function show($params)
    {
        $id = $params['id'];
        $user = $this->users[$id];
        $this->title = 'Пользователь ' . $user['name'];
        
        return $this->render('user/show', [
            'id' => $id,
            'user' => $user
        ]);
    }

    public function info($params)
    {
        $id = $params['id'];
        $key = $params['key'];
        $user = $this->users[$id];
        $this->title = 'Информация о пользователе';
        
        return $this->render('user/info', [
            'id' => $id,
            'key' => $key,
            'value' => $user[$key]
        ]);
    }

    public function all()
    {
        $this->title = 'Все пользователи';
        
        return $this->render('user/all', [
            'users' => $this->users
        ]);
    }

    public function first($params)
    {
        $n = $params['n'];
        $this->title = 'Первые ' . $n . ' пользователей';
        
        return $this->render('user/first', [
            'n' => $n,
            'users' => $this->users
        ]);
    }
}