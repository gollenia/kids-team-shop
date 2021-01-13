<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Twig\Renderer;
use Contexis\Core\Site;


class Show extends Controller {

    public function __construct($site, $is_ajax) {
        if($is_ajax) {
            header('HTTP/1.0 403 Forbidden'); 
            die();
        }
        parent::__construct($site, $is_ajax);
    }

    public function render() {
        echo Renderer::compile("pages/show.twig", $this->site->get());
    }
}