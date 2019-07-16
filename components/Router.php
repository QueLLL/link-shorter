<?php


namespace Components;


use Controllers\MainController;

class Router
{
    private $uri;
    private $routes;

    public function addRoute($uri, $path)
    {

    }

    public function __construct()
    {
        $this->uri = trim($_SERVER['REQUEST_URI'], '/');
    }

    public function run()
    {
        $uri = $this->uri;
        $controller = new MainController();


        if($uri == '') {
            $actionName = 'index';
        }
        if($uri == 'handle') {
            $actionName = 'handleForm';
        }
        elseif(preg_match('/[0-9A-Za-z]+/',$uri)) {
            $actionName = 'redirect';
            $params = $uri;
        }
        if(isset($actionName)){
            if(isset($params)){
                $controller->$actionName($params);
            }
            else{
                $controller->$actionName();

            }
        }
    }
}