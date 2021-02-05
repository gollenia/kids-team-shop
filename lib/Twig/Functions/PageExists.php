<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;
use dokuwiki\Extension\Event;

class PageExists extends CustomFunctions {

    public string $name = "page_exists";

    public function render($id = null) {
       return page_exists($id);
    }

}