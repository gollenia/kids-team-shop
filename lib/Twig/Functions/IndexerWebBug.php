<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;

class IndexerWebBug extends CustomFunctions {

    public string $name = "tpl_indexerWebBug";

    public function render() {
        
        ob_start();
        tpl_indexerWebBug();
        return ob_get_clean();
    }

}