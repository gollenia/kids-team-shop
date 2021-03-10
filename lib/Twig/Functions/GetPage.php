<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;
use dokuwiki\Extension\Event;
use Contexis\Models\Page;

/**
 * Get list of files in a given namespace
 */
class PageList extends CustomFunctions {

    public string $name = "get_page";

    public function render($id) {
        //var_dump(Page::where($key, $arg));
        return Page::find($id);
    }

}