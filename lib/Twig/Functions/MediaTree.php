<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;

class MediaTree extends CustomFunctions {

    public string $name = "tpl_mediaTree";

    public function render() {
        
        ob_start();
        tpl_mediaTree();
        return ob_get_clean();
    }

}