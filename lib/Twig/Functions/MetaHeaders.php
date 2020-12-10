<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;

class MetaHeaders extends CustomFunctions {

    public string $name = "tpl_metaheaders";

    public function render() {
        
        ob_start();
        tpl_metaheaders();
        return ob_get_clean();
    }

}