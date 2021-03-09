<?php
/**
 * This class heavily depends on the wiki's structure. It only works, if a base namespace for the bible-directory is given.
 */
namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Core\ControllerInterface;
use Contexis\Core\Site;
use Contexis\Models\Template;
use Contexis\Twig\Renderer;

use dokuwiki\Extension\Event;


class BibleView extends Controller implements ControllerInterface {

    public $book;
    public $verse;

    public function __construct($site) {
        parent::__construct($site);
        $content = $this->get_content();
        if($this->site->get('metadata')['template']) {
            $content = Template::apply($this->site->get('metadata')['template'], $content, $this->site->get("id"));
        }
        $this->site->add_data("content", $content); 
    }

    public function ajax_get_books() {
        $bible = \dokuwiki\plugin\bibleverse\Book::findAll();
        return json_encode($bible);
    }


    public function ajax_get_book($request) {
        $query = $request->str("query", "");
        $value = $request->str("value", "");
        $bible = \dokuwiki\plugin\bibleverse\Book::where($query, $value);
        return json_encode($bible);
    }


    public function ajax_count_verses($request) {
        $book = $request->str("book", "genesis");
        $chapter = $request->int("chapter", 1);
        $verses =  $request->str("verses", 1);
        $bible = \dokuwiki\plugin\bibleverse\Book::where("short_name", $book);
        if($bible) {
            return json_encode(count($bible->verse($chapter)));
        }
        return json_encode(0);
    }


    public function ajax_get_verses($request) {
        $book = $request->str("book", "genesis");
        $chapter = $request->int("chapter", 1);
        $verses =  $request->str("verses", 1);
        $bible = \dokuwiki\plugin\bibleverse\Book::where("short_name", $book);
        if($bible) {
            return json_encode($bible->verse($chapter));
        }
        
        return json_encode(false);
    }

    public function get_books() {
        $bibles = \dokuwiki\plugin\bibleverse\Book::findAll();
        return $bibles;
    }


    public function get_book($book) {
        $bible = \dokuwiki\plugin\bibleverse\Book::where("short_name", $book);
        return $bible;
    }

    public function get_verses($bible, $chapter) {
        $result = $bible->verse($chapter);
        return $result;
    }

    public function ajax_verse_count() {}
    
    private function get_content() {
        global $ACT;
        ob_start();
        Event::createAndTrigger('TPL_ACT_RENDER', $ACT, 'tpl_content_core');
        Event::createAndTrigger('TPL_CONTENT_DISPLAY', $html_output, 'ptln');
        $html_output = ob_get_clean();
        return $html_output;
    }

    

    public function render() {
        
        global $ID;
        $path=explode(":", $ID);

        if($path[1] == "start" || count($path) == 1) {
            return Renderer::compile("pages/show.twig", $this->site->get());
        }
        $bible = $this->get_book($path[1]);
        $verses = $this->get_verses($bible,$path[2]);
        $all_books = $this->get_books();
        $this->site->add_data("bible", ["book" => $bible, "verses" => $verses, "chapter" => $path[2], "base" => $path[0]]);
        $this->site->add_data("all_books", $all_books);
        
        $articles = \Contexis\Models\Page::where("tag", $bible->short_name);
        $articles_chapter = \Contexis\Models\Page::where("tag", $bible->short_name . $path[2]);
        
        $this->site->add_data("articles", $articles);
    
        return Renderer::compile("pages/bible.twig", $this->site->get());
    }
}

