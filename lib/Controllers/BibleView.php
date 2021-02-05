<?php
/**
 * This class heavily depends on the wiki's structure. It only works, if a base namespace for the bible-directory is given.
 */
namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Core\ControllerInterface;
use Contexis\Core\Site;
use Contexis\Twig\Renderer;
use Contexis\Models\BibleModel;


class BibleView extends Controller implements ControllerInterface {

    public function __construct($site) {
        parent::__construct($site);
    }

    private function get_bible_data() {
        global $INPUT;
        global $ID;
    
        if (!class_exists("\dokuwiki\plugin\bibleverse\Model")) {
            return array(
                "book" => ["id" => "", "title" => "", "chapters" => 0],
                "translation" => "",
                "chapter" => "",
                "verses" => []
            );
        }
        $bible = new \dokuwiki\plugin\bibleverse\Model($ID);

        $bible->query();

        return $bible->get();
    }

    public function render() {
        
        global $ACT;
        
        global $INPUT;

        
        $bible = $this->get_bible_data();
        $this->site->add_data("bible", $bible);
        
        $articles = \Contexis\Models\Page::where("tag", $bible["book"]["id"]);
        $this->site->add_data("articles", $articles);
    
        return Renderer::compile("pages/bible.twig", $this->site->get());
    }
}