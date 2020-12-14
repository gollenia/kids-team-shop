<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;

class HTMLMsgArea extends CustomFunctions {

    public string $name = "html_msgarea";

    public function render() {
        
        ob_start();
        html_msgarea();
        return ob_get_clean();
    }

}