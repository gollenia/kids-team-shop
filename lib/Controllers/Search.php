<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Twig\Renderer;
use Contexis\Core\Site;

class Search extends Controller {

    public function __construct($site, $is_ajax) {
        parent::__construct($site, $is_ajax);
    }

    public function render() {
        
        global $ACT;
        
        global $INPUT;

        return Renderer::compile("pages/search.twig", $this->site->get());
    }
	
}





















