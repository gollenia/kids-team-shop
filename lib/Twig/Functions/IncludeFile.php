<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;
use dokuwiki\Extension\Event;

class IncludeFile extends CustomFunctions {

    public string $name = "tpl_includeFile";

    public function render($file = "") {
       return tpl_includeFile($file);
    }

}