<?php


namespace Components;


use Controllers\MainController;

class Router
{
    private $uri;

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
        switch ($uri) {
            case(""):
                $actionName = 'index';
                break;
            case('handle'):
                $actionName = 'handleForm';
                break;
            case(preg_match('/^[0-9A-Za-z]+/',$uri)? true : false):
                $actionName = 'redirect';
                $params = $uri;
                break;
        };

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