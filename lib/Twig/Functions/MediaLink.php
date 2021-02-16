<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;

class MediaLink extends CustomFunctions {

    public string $name = "ml";

    public function render($id, $width = false) {
        return ml($id, ["w" => $width], true, '&');
    }

}