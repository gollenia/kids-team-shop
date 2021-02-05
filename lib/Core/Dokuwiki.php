<?php
namespace Contexis\Core;

/**
 * Dokuwiki functions for every day usage
 * 
 * @since 1.0.0
 */

class Dokuwiki {

    
    public static function get_title($id = ":start") {
        global $conf;
        $title = false;
        if ($conf['useheading']) {
            $title = p_get_first_heading($id);
        }
        if (!$title) {
            $title = p_get_first_heading($id . ":start");
        }
        if (!$title) {
            $title = noNSorNS($id);
        }

        return $title;
    }

   

    public static function get_child_pages($namespace) {
        global $conf;
        $data = [];
        $opts= [
            "level" => 1,
            "listdirs" => 1
        ];
        search($data, $conf['datadir'], 'search_universal', $opts, $namespace);
        return $data;
    }

    public static function get_child_page_ids($namespace) {
        $ids = [];
        $pages = self::get_child_pages($namespace);
        foreach($pages as $item) {         
            array_push($ids, end(explode(":", $item['id'])));   
        }
        return $ids;
    }

    public static function get_page_id($page) {
        return end(explode(":", $page));
    }
    
}