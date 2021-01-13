<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Twig\Renderer;


class Edit extends Controller {

    public function __construct($site, $is_ajax) {
        if($is_ajax) {
            header('HTTP/1.0 403 Forbidden'); 
            die();
        }
        parent::__construct($site);
    }

    public function render() {
        echo Renderer::compile("pages/edit.twig", $this->site->get());
    }
}