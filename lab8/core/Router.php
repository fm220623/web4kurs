<?php
namespace Core;

class Router
{
    public function getTrack($routes, $uri)
    {
        echo "<!-- Debug: Router ищет роут для URI: $uri --><br>";
        
        foreach ($routes as $route) {
            $pattern = $this->createPattern($route->path);
            echo "<!-- Проверяем роут: {$route->path} -> паттерн: $pattern --><br>";
            
            if (preg_match($pattern, $uri, $params)) {
                $params = $this->clearParams($params);
                echo "<!-- Найден роут: {$route->controller}::{$route->action}() --><br>";
                return new Track($route->controller, $route->action, $params);
            }
        }
        
        echo "<!-- Роут не найден, возвращаем hello/index --><br>";
        return new Track('hello', 'index');
    }
    
    private function createPattern($path)
    {
        return '#^' . preg_replace('#/:([^/]+)#', '/(?<$1>[^/]+)', $path) . '/?$#';
    }
    
    private function clearParams($params)
    {
        $result = [];
        
        foreach ($params as $key => $param) {
            if (!is_int($key)) {
                $result[$key] = $param;
            }
        }
        
        return $result;
    }
}