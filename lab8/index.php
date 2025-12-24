<?php
namespace Core;

error_reporting(E_ALL);
ini_set('display_errors', 'on');

require_once $_SERVER['DOCUMENT_ROOT'] . '/lab8/project/config/connection.php';

spl_autoload_register(function($class) {
    $className = basename(str_replace('\\', '/', $class));
    $paths = [
        $_SERVER['DOCUMENT_ROOT'] . '/lab8/core/' . $className . '.php',
        $_SERVER['DOCUMENT_ROOT'] . '/lab8/project/controllers/' . $className . '.php',
        $_SERVER['DOCUMENT_ROOT'] . '/lab8/project/models/' . $className . '.php',
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return true;
        }
    }
    
    throw new \Exception("Класс $class не найден");
});

$uri = $_SERVER['REQUEST_URI'];

if (strpos($uri, '/lab8/') === 0) {
    $uri = substr($uri, strlen('/lab8'));
}

if ($uri == '' || $uri == '/lab8') {
    $uri = '/';
}

$routes = require $_SERVER['DOCUMENT_ROOT'] . '/lab8/project/config/routes.php';

$track = ( new Router )->getTrack($routes, $uri);

$page  = ( new Dispatcher )->getPage($track);

echo (new View)->render($page);