<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;
use dokuwiki\Extension\Event;

class WikiLink extends CustomFunctions {

    public string $name = "tpl_link";

    public function render($id = null) {
       return wl($id);
    }

}