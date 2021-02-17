<?php

namespace Contexis\Models;

use Contexis\Database\Index;

class Page {

    public string $id;
    public $tags;
    public string $pageimage ="";
    public string $content;
    public string $summary = "";
    public string $date;
    public string $abstract = "";
    public string $user;
    public bool $minor_change = false;
    
    /**
     * Find a single page by it's id and retrieve all additional data
     *
     * @param string $id
     * @return \Contexis\Models\Page $instance 
     */
    public static function find(string $id) {
        if (!page_exists($id) || auth_quickaclcheck($id) < AUTH_READ) {
            return false;
        }

        $instance = new static();
        $instance->id = $id;
        $instance->tags = p_get_metadata($id, 'subject');
        $instance->title = p_get_metadata($id, 'title');
        $instance->pageimage = p_get_metadata($id, 'pageimage') ?: '';
        $instance->user = p_get_metadata($id, 'user');
        $instance->date = p_get_metadata($id, 'date modified');
        $instance->content = rawWiki($id);
        $instance->abstract = "";
        $abstract = p_get_metadata($id, 'abstract');
        if($abstract) {
            $instance->abstract = $abstract;
        }
        
        return $instance;
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
     * General search function, whicht retrieves a list of pages by it's meta data
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function where(string $key, $value) {
        if($key == "id") {
            global $conf;
            $data = [];
            $id = str_replace(':', "/", $value);
            search($data,$conf['datadir'],array('\\Contexis\\Database\\Index','_search'),array(),$id,1,'natural');
            
            foreach($data as $key => $value) {
                    $data[$key]['meta'] = p_get_metadata($value['id']);
            }
        }
        if($key == "tag" || $key == "subject") {
            $tag = \Contexis\Database\Tag::getPagesByTag($value);
            return $tag;
        }

        return idx_get_indexer()->lookupKey($key, $value);
    }

    /**
     * Save page including it's metadata
     *
     * @return bool True fopr success, false for failure
     */
    public function save() {
        
        if(auth_quickaclcheck($this->id) < AUTH_EDIT || checklock($this->id)) {
            return false;
        }

        p_set_metadata($this->id, ['subject' => $this->tags]);
        p_set_metadata($this->id, ['pageimage' => $this->pageimage]);
        
        
        lock($this->id);
        saveWikiText($this->id, $this->content ,$this->summary, $this->minor_change);
        idx_addPage($this->id, false, true);
        unlock($this->id);
       
        p_set_metadata($this->id, ['abstract' => $this->abstract]);
        return true;
    }

    /**
     * List all pages within a Namespace, including depth (tree?)
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
