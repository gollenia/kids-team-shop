<?php

namespace Contexis\Models;

use Contexis\Database\Index;

class Page {

    public string $id;
    public array $tags = [];
    public string $pageimage ="";
    public string $title = "";
    public string $content ="";
    public string $summary = "";
    public string $link = "";
    public string $exclude = "";
    public string $template = "";
    public string $pagelink = "";
    public string $date;
    public string $abstract = "";
    public string $user;
    public bool $minor_change = false;
    
    /**
     * Find a single page by it's id and retrieve all additional data
     *
     * @param string $id
     * @return \Contexis\Models\Page $instance or bool false
     */
    public static function find($id) {
        if (!$id) {
            
            return false;
        }
        if (!page_exists($id) || auth_quickaclcheck($id) < AUTH_READ) {
            //var_dump("not found");
            return false;
        }

        $instance = new static();
        $instance->id = $id;
        $instance->tags = p_get_metadata($id, 'subject') ? p_get_metadata($id, 'subject') : [];
        $instance->title = p_get_metadata($id, 'title') ?: '';
        $instance->pageimage = p_get_metadata($id, 'pageimage') ?: '';
        $instance->pagelink = p_get_metadata($id, 'pagelink') ?: '';
        $instance->user = p_get_metadata($id, 'user');
        $instance->link = wl($id);
        $instance->date = p_get_metadata($id, 'date modified');
        $instance->template = p_get_metadata($id, 'template') ?: '';
        $instance->content = rawWiki($id);
        $instance->exclude = p_get_metadata($id, 'exclude') ?: '';
        $instance->abstract = "";
        $abstract = p_get_metadata($id, 'abstract');
        if($abstract) {
            $instance->abstract = $abstract;
        }
        
        return $instance;
    }

    /**
     * get raw wiki test either without or with template
     *
     * @param string $id
     * @return string raw wiki text
     */
    public function get_raw(string $id) {
        if(p_get_metadata($id, 'raw')) {
            return (p_get_metadata($id, 'raw'));
        }
        return ($id);
    }

    /**
     * Used to create a new page OR get a pa page, if it already exists
     *
     * @param string $id
     * @param array $data
     * @return \Contexis\Models\Page $instance 
     * 
     */
    public static function findOrNew(string $id, array $data = []) {
        if (!($instance = self::find($id))) {
            $instance = new static();
            $instance->id = $id;
            foreach ($data as $key => $value) {
                    $instance->$key = $value;
            }
        }
        return $instance;
    } 

    /**
     * General search function, whicht retrieves a list of pages by it's id or metadata
     *
     * @param string $key
     * @param mixed $value
     * @return array of Pages
     */
    public static function where(string $key, $value) {

        $pages = [];
        $data = [];

        switch ($key) {
            case "id":
                global $conf;
                $id = str_replace(':', "/", $value);
                search($data,$conf['datadir'],array('\\Contexis\\Database\\Index','_pages'),array(),$id,1,'natural');
                break;
            case "tag":
                $data = \Contexis\Database\Tag::getPagesByTag($value);
                break;
            default:
                $data = idx_get_indexer()->lookupKey($key, $value);
        }

        foreach($data as $key => $value) {            
            array_push($pages, self::find($value['id']));
        }
        return $pages;
    }


    /**
     * Save page including it's metadata
     *
     * @return bool True for success, false for failure
     */
    public function save() {
        
        if(auth_quickaclcheck($this->id) < AUTH_EDIT || checklock($this->id)) {
            return false;
        }

        p_set_metadata($this->id, ['subject' => $this->tags]);
        p_set_metadata($this->id, ['pageimage' => $this->pageimage]);
        
        $content = $this->content;

        lock($this->id);
        saveWikiText($this->id, $content ,$this->summary, $this->minor_change);
        p_set_metadata($this->id, ['abstract' => $this->abstract]);
        p_set_metadata($this->id, ['title' => $this->title]);
        p_set_metadata($this->id, ['pagelink' => $this->pagelink]);
        p_set_metadata($this->id, ['template' => $this->template]);
        p_set_metadata($this->id, ['exclude' => $this->exclude]);
        idx_addPage($this->id, false, true);
        unlock($this->id);
       
        return true;
    }

    /**
     * Get Tree. This function does not fit into the page model as it does not return a Page Opbject.
     *
     * @param [type] $namespace
     * @return void
     */
    public static function findAll($namespace = "", $excludePages = false, $excludes = "" ) {
        $index = new Index();
        return $index->tree($namespace, $excludes, $excludePages);
    }

    /**
     * Get full page Object including all meta data
     *
     * @return array Page Data
     */
    public function get(){
        return get_object_vars($this);
    }

    /**
     * Delete page
     *
     * @return bool True for sucess, fals for failure
     */
    public function delete() {
        if(auth_quickaclcheck($this->id) < AUTH_EDIT || checklock($this->id)) {
            return false;
        }
        saveWikiText($this->$id,"","");
        return true;
    }



}
