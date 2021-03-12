<?php
namespace Contexis\Core;

class Router {

    private $routes; 

    public function __construct($routes) {
        $this->routes = $routes;
    }

    public function get() {
        $controller = $this->get_act();
        
        foreach ($this->routes as $route => $isTrue) {        
            if ($isTrue ) {
                $controller = $route;
                break;
            }
        }

        return $controller;
    }

    public function get_act() {
        global $ACT;
        if (!is_array($ACT) && class_exists("Contexis\\Controllers\\" . ucfirst($ACT))) {
            return "Contexis\\Controllers\\" . $ACT;
        }

        return "Contexis\\Controllers\\Fallback";
    }
}