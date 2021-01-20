<?php
/**
 * This class heavily depends on the wiki's structure. It only works, if a base namespace for the bible-directory is given.
 */
namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Core\Site;
use Contexis\Twig\Renderer;
use Contexis\Models\BibleModel;


class BibleView extends Controller {

    public function __construct($site, $is_ajax) {
        parent::__construct($site, $is_ajax);
    }

    private function get_bible_data() {
        global $INPUT;
        global $ID;
    
        $bible = new \dokuwiki\plugin\bibleverse\Model($ID);
        $bible->query();

        return $bible->get();
    }

    public function render() {
        
        global $ACT;
        
        global $INPUT;

        

        $tags = new \Contexis\Models\Tag();
        $articles = $tags->getTopic("", NULL, "1mose");
        
        $this->site->add_data("articles", $articles);
        
        $this->site->add_data("bible", $this->get_bible_data());
        //var_dump($this->get_bible_data());
        return Renderer::compile("pages/bible.twig", $this->site->get());
    }
}