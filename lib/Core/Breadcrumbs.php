<?php

namespace Contexis\Core;

use Contexis\Core\Dokuwiki;

class Breadcrumbs {

    public static function get() {

        global $conf;
        global $ID;
        global $lang;
 

        $parts = explode(':', $ID);
        $count = count($parts);

        $breadcrumbs = [];
        
        $part = "";
        for($i = 0; $i < $count - 1; $i++) {
            $part .= $parts[$i].':';
            $page = $part;
            if($page == $conf['start']) continue; // Skip startpage
            
            array_push($breadcrumbs, ["link" => wl($page, '', true), "title" => Dokuwiki::get_title($page)]);
        }
        resolve_pageid('', $page, $exists);

        if (isset($page) && $page == $part.$parts[$i]) {
            return $breadcrumbs;
        }

        
        $page = $part.$parts[$i];
        if($page == $conf['start']) {
            return $breadcrumbs;
        }
        
        array_push($breadcrumbs, tpl_pagelink($page, null, true));
        
        return $breadcrumbs;
    }

}