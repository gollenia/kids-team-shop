<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Twig\Renderer;


class Login extends Controller {
    public function __construct($site, $is_ajax) {
        if($is_ajax) {
            header('HTTP/1.0 403 Forbidden'); 
            die();
        }
        parent::__construct($site, $is_ajax);
    }

    public function render() {
        echo Renderer::compile("pages/login.twig", $this->site->get());
    }
}