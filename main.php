<?php

use Contexis\Core\{
        Site,
        Router,
        Config
};



$site = new Site();

$route = new Router(Config::load("routes"));

$controllerClass = $route->get();

$controller = new $controllerClass($site);

echo $controller->render($twig);

tpl_indexerWebBug();

// important function to build the index etc.


