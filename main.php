<?php

require __DIR__ . '/vendor/autoload.php';

use Contexis\Core\{
        Site,
        Router,
        Config
};



global $INPUT;

$site = new Site();
$route = new Router(Config::load("routes"));

if($INPUT->str('controller',false)) {
        
        $controllerName = ucfirst ( $INPUT->str('controller'));
	$controllerName = "Contexis\\Controllers\\" . $controllerName;
	$controller = new $controllerName($site, true);
	$method = $INPUT->str('method', 'get');
        
        if (method_exists( $controller, $method)) {
                header('Content-Type: application/json');
                echo call_user_func_array ( array($controller, $method), []); // , [$INPUT]
                
        } else {
                header('Content-Type: application/json');
                echo "{error: 'method " . $method . " in controller " . $controllerName . " not found'}";
                
        }
} else {

        $controllerClass = $route->get();
        $controller = new $controllerClass($site, false);
        echo $controller->render($twig);
        tpl_indexerWebBug();
}



// important function to build the index etc.


