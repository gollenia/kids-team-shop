<?php
namespace Contexis\Twig\Filters;

use Contexis\Twig\CustomFilters;
use dokuwiki\Extension\Event;

class Title extends CustomFilters {

    public string $name = "title";

    function render($id)
    {
        $title =  ucfirst($id);
        $title = str_replace("_", " ", $title);
        return $title;
    }

}