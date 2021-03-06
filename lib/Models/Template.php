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
        
        $page = Page::find($id);
        if(!$template) {
            return Renderer::compile("partials/default.twig", ["content" => $content, "id" => $id, "page" => $page]);
        }
        return Renderer::compile_string($template->content, ["content" => $content, "id" => $id, "page" => $page]);
    }
}