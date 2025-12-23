<?php
namespace Project\Controllers;
use \Core\Controller;

class TestController extends Controller
{
    public function act1()
    {
        $this->title = 'Действие 1 - TestController';
        return $this->render('test/act1');
    }

    public function act2()
    {
        $this->title = 'Действие 2 - TestController';
        return $this->render('test/act2');
    }

    public function act3()
    {
        $this->title = 'Действие 3 - TestController';
        return $this->render('test/act3');
    }
}