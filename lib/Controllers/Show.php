<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Twig\Renderer;
use Contexis\Core\Site;


class Show extends Controller {

    public function __construct($site) {
        parent::__construct($site);
    }

    public function render() {
        echo Renderer::compile("pages/show.twig", $this->site->get());
    }
}