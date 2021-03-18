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
        $data = json_decode($request->str("page"));
        $page = Page::findOrNew($data->id);
        $page->content = cleanText($data->content);
        $page->abstract = cleanText($data->abstract);
        $page->tags =  cleanText($data->tags);
        $page->pageimage = cleanText($data->pageimage);
        $page->category = cleanText($data->category);
        $page->pagelink = cleanText($data->pagelink);
        $page->icon = strtolower(str_replace(" ", "_", cleanText($data->icon)));
        $page->exclude = cleanText($data->exclude);
        $page->template = cleanText($data->template);
        $page->title = cleanText($data->title);
        $page->save();
        return json_encode($page->get());
    }

    public function ajax_list(Input $request) {
        $id = $request->str("id", ":");
        $page = Page::where("id", $id);
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
}