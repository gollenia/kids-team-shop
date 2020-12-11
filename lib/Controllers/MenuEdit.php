<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;


class MenuEdit extends Controller {
    public function __construct($page) {
        parent::__construct($page);
    }

    public function render() {
        echo "editing";
    }
}