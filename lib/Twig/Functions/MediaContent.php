<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;

class MediaContent extends CustomFunctions {

    public string $name = "tpl_mediaContent";

    public function render() {
        
        ob_start();
        tpl_mediaContent();
        return ob_get_clean();
    }

}