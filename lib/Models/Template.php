<?php
namespace Contexis\Models;

use \Contexis\Models\Page;

class Template {

    private string $template; 
    private array $args;

    public function __construct() {
        
    }

    public function get() {
        
    }

    static public function get_all() {
        return Page::where('id', 'system:templates');
    }

    public static function apply($wiki_text) {
        
    }
}