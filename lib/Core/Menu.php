<?php

namespace Contexis\Core;

use Contexis\Core\Dokuwiki;
use Contexis\Core\Utilities;


class Menu {

    private $menu = [];

    /**
     * Generate recursive menu array from given namespace
     *
     * @param string $start
     * @param int $depth
     * @return void
     */
    

    public static function get($id) {
        return json_decode(rawWiki($id));
    }

}