<?php

require __DIR__ . '/vendor/autoload.php';

use Contexis\Core\{
        Site,
        Router,
        Config,
        Controller
};



global $INPUT;

$site = new Site();
$route = new Router(Config::load("routes"));

$controller = Controller::get($route->get(), $site);



// important function to build the index etc.
