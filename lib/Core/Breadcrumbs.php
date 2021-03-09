<?php

namespace Contexis\Core;

use Contexis\Core\Dokuwiki;

class Breadcrumbs {

    public static function get() {

        global $conf;
        global $ID;
        global $lang;
 

        $parts = explode(':', $ID);
        

        $breadcrumbs = [];
        
        $part = "";

        
        for($i = 0; $i < count($parts); $i++) {
            $part .= $parts[$i].':';
            $title = Dokuwiki::get_title($part);
            if($parts[0] == "bibel" && $i == 1) {
                $bible = \dokuwiki\plugin\bibleverse\Book::where("short_name", $parts[1]);
                $title = $bible->long_name;
            }
            array_push($breadcrumbs, ["link" => \wl($part, '', true), "title" => $title]);
        }
        
        return $breadcrumbs;
    }

    public static function get_bible($book) {

    }

}