<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;
use dokuwiki\Extension\Event;

class PageTitle extends CustomFunctions {

    public string $name = "tpl_pagetitle";

    public function render($id = null) {
       return tpl_pagetitle($id, true);
    }

}