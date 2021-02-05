<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Core\ControllerInterface;
use Contexis\Models\Page;
use Contexis\Twig\Renderer;
use \dokuwiki\Input\Input;


class Edit extends Controller implements ControllerInterface {

    public function __construct($site) {
        parent::__construct($site);
    }

    public function render() {
        echo Renderer::compile("pages/edit.twig", $this->site->get());
        
    }

    public function ajax_get(Input $request) {
        $id = $request->str("id", "");
        $page = Page::findOrNew($request->str("id", ""));
        if(!$page) {
            return json_encode(["error" => "No ID given"]);
        }
        return json_encode($page->get());
    }

    public function ajax_save(Input $request) {
        $page = Page::findOrNew($request->str("id"));
        $page->content  = cleanText($request->str('content'));
        $page->sum   = $request->str('sum', $page->sum);
        $page->minor_change = $request->str('minor', $page->minor_change);
        $page->tags = json_decode($request->str('tags'));
        $page->save();
        return json_encode($page->get());
    }

    public function ajax_list(Input $request) {
        $page = Page::where("id", ":bibel");
        return json_encode($page);
    }

    public function ajax_tree(Input $request) {
        $id = $request->str("id", ""); 
        $pageTree = Page::findAll($id, false, "bibel,system");
        return json_encode($pageTree);
    }

    public function ajax_delete(Input $request) {
        $id = $request->str("id", "");
        $page = Page::find($id);
        $page->delete();
    }

    public ajax_getTemplates(Input $request) {
        
    }
}