<?php

namespace Contexis\Core;

use Contexis\Core\Site;



interface ControllerInterface {
    
    public function __construct(Site $site, $is_ajax);
    public function render();
}


class Controller implements ControllerInterface {

    public Site $site;

    public function __construct(Site $site, $is_ajax)
    {
        $this->site = $site;
    }

    public function render() {
        echo "No rendering method implemented";
    }

    private function get_act_controller() {

    }
}