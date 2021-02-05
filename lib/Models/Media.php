<?php

namespace Contexis\Models;

use Contexis\Models\Page;
use \dokuwiki\Input\Input;

class Media {

    public string $id;
    public string $path;
    public string $link;
    public string $user;
    public bool $minor_change = false;
    
    public static function find(string $id) {
        if (!page_exists($id) || auth_quickaclcheck($id) < AUTH_READ) {
            return false;
        }

        $instance = new static();
        $instance->id = $id;
        $instance->tags = p_get_metadata($id, 'subject');
        $instance->title = p_get_metadata($id, 'title');
        $instance->image = p_get_metadata($id, 'pageimage') || "";
        $instance->user = p_get_metadata($id, 'user');
        $instance->date = p_get_metadata($id, 'date modified');
        $instance->abstract = p_get_metadata($id, 'description abstract');
        $instance->content = rawWiki($id);
        return $instance;
    }

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
    public static function where(string $key, mixed $value) {
        if($key == "id") {

        }
        if(!plugin_isdisabled('tag') && ($key == "tag" || $key == "subject")) {
            $tag = plugin_load('helper', 'tag');
            return $tag->getTopic($value);
        }

        return idx_get_indexer()->lookupKey($key, $value);
    }

    /**
     * Save page including it's metadata
     *
     * @return void
     */
    public function save() {
        
		$id = $this->id;
	    $auth = auth_quickaclcheck(getNS($id).':*');
	    
	    if($auth < AUTH_UPLOAD) { 
	    	return ['status' => 403, 'error' => 'Keine Berechtigung"'];
	    }
	    
	    $file = $_FILES['file'];
	    $id   = $id . ':' . $file['name'];
			if(empty($id)) $id = $file['name'];

	    // check for errors (messages are done in lib/exe/mediamanager.php)
	    if($file['error']) return false;
	
	    // check extensions
	    list($fext,$fmime) = mimetype($file['name']);
	    list($iext,$imime) = mimetype($id);
	    
	    $res = media_save(array('name' => $file['tmp_name'],
	                            'mime' => $imime,
	                            'ext'  => $iext), $ns.':'.$id,
	                      		$INPUT->bool('ow', false), $auth, 'copy_uploaded_file');
	    if (is_array($res)) {
	        msg($res[0], $res[1]);
	        return false;
	    }
	    return $res;
    }

    public static function findAll($namespace) {

    }

    /**
     * Get full page Object including all meta data
     *
     * @return array Page Data
     */
    public function get(){
        return get_object_vars($this);
    }

    public function delete() {
        
		$id = $this->id;
        
        if(auth_quickaclcheck(getNS($id).':*') < AUTH_DELETE) return new IJR_ERROR(1, "You don't have permissions to delete files.");
        global $conf;
        
        // check for references if needed
        $mediareferences = array();
        if($conf['refcheck']){
            require_once(DOKU_INC.'inc/fulltext.php');
            $mediareferences = ft_mediause($id,$conf['refshow']);
        }

        if(!count($mediareferences)){
            $file = mediaFN($id);
            if(@unlink($file)){
                require_once(DOKU_INC.'inc/changelog.php');
                addMediaLogEntry(time(), $id, DOKU_CHANGE_TYPE_DELETE);
                io_sweepNS($id,'mediadir');
                return 0;
            }
            //something went wrong
               return new IJR_ERROR(1, 'Could not delete file');
        } else {
            return new IJR_ERROR(1, 'File is still referenced');
        }
    }



}