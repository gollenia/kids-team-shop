<?php

namespace Contexis\Models;

use Contexis\Core\Utilities\Strings;
use Contexis\Core\Dokuwiki;

class BibleModel {
    
    private string $book;
    private int $chapter;
    private array $verses;

    private $base;

    private $response = [
        "book" => ["id" => "", "title" => ""],
        "translation" => "",
        "chapter" => "",
        "verses" => []
    ];

    /**
     * Constructor function
     *
     * @param string $id
     * @param int $chapter
     * @param mixed $verses
     * @param string $base
     * 
     * @todo can we make this function take less arguments?
     */
    public function __construct(string $id, $verses = "0") {
        $path = explode(":", $id);
        $this->set_book($path[1]);
        $this->set_chapter($path[2]);
        $this->set_verses($verses);
        $this->base = $path[0];
    }

    /**
     * get function
     * 
     * returns the query object
     *
     * @return array
     */
    public function get() {
        return $this->response;
    }

    public function query() {
        $query_result = json_decode(rawWiki($this->base . ":" . $this->book . ":" . $this->chapter));

        $this->response["book"] = ["id" => $query_result->book, "title" => $this->get_book_title($this->book, $query_result->book)];
        $this->response["translation"] = $query_result->translation;
        $this->response["chapter"] = $query_result->chapter;

        if($this->verses != [0]) {
            
            foreach($this->verses as $number) {            
                $verse = $query_result->verses[$number -1];
                array_push($this->response['verses'], $verse);
            }
            return;
        }
        
        $this->response["verses"] = $query_result->verses;
    }

    public function set_book($book) {
        $books = $this->get_all_book_ids();
        if(!in_array($book, $books)) {
            $this->book = "matthaeus";
            return;
        }

        $this->book = $book;
    }

    public function get_all_book_ids() {
        
        return Dokuwiki::get_child_page_ids($this->base);

    }

    public function get_all_books() {
        
        $child_pages = Dokuwiki::get_child_page_ids($this->base);

        $books = [];

        foreach($child_pages as $item) {
            array_push($books, [
                "id" => $item, 
                "title" => $this->get_book_title($item, ""), 
                "link" => wl($this->base . ":" . $item)
            ]);   
        }

        return $books;
    }

    public function set_chapter($chapter) {
        $this->chapter = intval($chapter);
    }

    public function set_verses(string $verses) {

        if(strpos($verses,"-")) {
            $this->verses = Strings::to_array_field($verses, "-", 100);
            return;
        }

        if(strpos($verses,",")) {
            $verse_array = explode(",", $verses);
            $this->verses = array_map('intval', $verse_array);;
            return;
        }

        $this->verses = [intval($verses)];

    }

    public function get_book_title($book, $fallback) {
        $title = p_get_first_heading($this->base . ":" . $book);
        if($title == "") {
            $title = $fallback;
        }
        return $title;
    }

    public function get_formatted() {

    }

}