<?php
namespace Contexis\Models;

use \Contexis\Models\Page;
use Contexis\Twig\Renderer;

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

    public static function apply($template, $content, $id) {
        $template = Page::find($template);
        return Renderer::compile_string($template->content, ["content" => $content, "id" => $id]);
    }
}