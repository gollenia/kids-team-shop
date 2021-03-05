<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use \Contexis\Models\Page;
use Contexis\Models\Template;
use \Contexis\Twig\Renderer;
use dokuwiki\Extension\Event;

class Show extends Controller {

    public function __construct($site) {
        parent::__construct($site);
        $content = $this->get_content();
        if($this->site->get('metadata')['template']) {
            $content = Template::apply($this->site->get('metadata')['template'], $content, $this->site->get("id"));
        }
        $this->site->add_data("content", $content);     
    }

    private function get_content() {
        global $ACT;
        ob_start();
        Event::createAndTrigger('TPL_ACT_RENDER', $ACT, 'tpl_content_core');
        Event::createAndTrigger('TPL_CONTENT_DISPLAY', $html_output, 'ptln');
        $html_output = ob_get_clean();
        return $html_output;
    }

    
   
    
}