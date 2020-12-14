<?php

// Can we use the routing system here? 

use Contexis\Core\{
        Site,
        Router,
        Config
};

use Contexis\Twig\Renderer;

$site = new Site();

echo Renderer::compile("pages/mediamanager.twig", $site->get());

tpl_indexerWebBug();