<?php
namespace Contexis\Twig\Filters;

use Contexis\Twig\CustomFilters;
use dokuwiki\Extension\Event;

class FileSize extends CustomFilters {

    public string $name = "filesize";

    function render($size)
    {
        // Pick units
        $size = intval($size);
        $suffix = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        
        // Max unit to display
        $depth = count($suffix) - 1;
     
        // Loop
        $i = 0;
        while ($size >= 1000 && $i < $depth) {
            $size /= 1000;
            $i++;
        }

        return sprintf('%01.2f %s', $size, $suffix[$i]);
    }

}