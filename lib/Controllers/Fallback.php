<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Twig\Renderer;

class Fallback extends Controller {

    public $template = "default";

    public function __construct($site) {
        global $ID;
        parent::__construct($site);
    }

    

    public function render() {
        echo Renderer::compile("pages/default.twig", $this->site->get());
    }
}





















