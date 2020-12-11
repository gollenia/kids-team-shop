<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;
use dokuwiki\Extension\Event;

class Content extends CustomFunctions {

    public string $name = "tpl_content";

    public function render($prependTOC) {
        global $ACT;
        global $INFO;
        $INFO['prependTOC'] = $prependTOC;
    
        ob_start();
        Event::createAndTrigger('TPL_ACT_RENDER', $ACT, 'tpl_content_core');
        Event::createAndTrigger('TPL_CONTENT_DISPLAY', $html_output, 'ptln');
        $html_output = ob_get_clean();
        return $html_output;
    }

}