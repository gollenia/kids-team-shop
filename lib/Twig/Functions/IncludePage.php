<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;

class IncludePage extends CustomFunctions {

    public string $name = "tpl_include_page";

    public function render($page, $nearest) {
        if($nearest) { $page = page_findnearest($page); }
        ob_start();
        tpl_include_page($page);
        return ob_get_clean();
    }

}