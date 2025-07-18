<?php

class Router{

    protected $routes = [];

    public function __construct(){
        $this->loadRoutes('web');
    }

    public function get(string $uri, array $action){
        $this->routes['GET'][$uri] = $action;
    }
    
    public function post(string $uri, array $action){
        $this->routes['POST'][$uri] = $action;
    }

    public function delete(string $uri, array $action){
        $this->routes['DELETE'][$uri] = $action;
    }

    public function put(string $uri, array $action){
        $this->routes['PUT'][$uri] = $action;
    }

    public function run(){

        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

        $action = $this->routes[$method][$uri] ?? null;

        // var_dump($this->routes);
        // die();

        if(!$action){
            exit('Route not found'. $method . ' ' . $uri);
        }
        
        [$controller, $method] = $action;

        (new $controller())->$method();
    }

    public function loadRoutes(string $file){
        $router = $this;
        $filePath = __DIR__ . '/../routes/' . $file . '.php';
        require $filePath;
    }
}