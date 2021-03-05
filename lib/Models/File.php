<?php

namespace Contexis\Models;


class File {

    public string $id;
    public string $path;
    public string $thumbnail;
    public string $src;
    public string $full;
    public string $filename;
    public string $size;
    public string $modified;
    public string $extension;
    public string $info;
    public bool $writable;
    public bool $minor_change = false;
    
    /**
     * Undocumented function
     *
     * @param string $id ID of the media file
     * @return Contexis\Models\Media Media Object
     */
    public static function find(string $id) {
        $filename = mediaFN($id);

        if (!media_ispublic($id) && !file_exists($filename)) {
            return false;
        }

        $instance = new static();
        $instance->id = $id;
        $instance->path = $filename;
        $instance->file = pathinfo($filename, PATHINFO_BASENAME);
        $instance->modified = filemtime($filename);
        $instance->writable =is_writable($filename);
        $instance->size = filesize($filename);
        $instance->extension = pathinfo($filename, PATHINFO_EXTENSION);
        $instance->src = ml($id);
        $instance->thumbnail = in_array(strtolower($instance->extension), ['jpg', 'jpeg', 'png']) ? ml($id, ['w' => 600]) : "";
        return $instance;
    }

    public static function create($ns) {
        $auth = auth_quickaclcheck(getNS($ns).':*');

        $upload = media_upload($ns, $auth);
        if ($upload) {
            return self::find($ns . ":" . $upload);
        }
	    
	    return $upload;

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
        if (media_delete($id, 0) === 1) {
            return true;
        }
        return false;
    }

    /**
     * Get list of files in a namespace and filter them by a wildcard pattern
     *
     * @param string $ns
     * @param string $excludes 
     * @return array List of files
     */
    public static function findAll($ns, $excludes = "") {
        global $conf;
	
	    if(auth_quickaclcheck("$ns:*") < AUTH_READ){
	        return false;
	    }
	
        $dir = utf8_encodeFN(str_replace(':','/',$ns));
        $data = [];
        search($data,$conf['mediadir'],'search_media',['showmsg'=>false,'depth'=>1],$dir);
                                
        $result = [];
        
        foreach ($data as $item) {
            $file = self::find($item['id']);
            
            if (fnmatch($excludes, $item['file'])) {
                continue;
            }
            array_push($result, $file->get());
            unset($file);
            
        }
            
        return $result;
    }


    /**
     * @param mixed $ns 
     * @param string $filter 
     * @return false|array 
     */
    public static function findAllByWildcard($ns, $filter = "*.*") {
        global $conf;
	
	    if(auth_quickaclcheck("$ns:*") < AUTH_READ){
	        return false;
	    }
	
        $dir = utf8_encodeFN(str_replace(':','/',$ns));
        $data = [];
        search($data,$conf['mediadir'],'search_media',['showmsg'=>false,'depth'=>1],$dir);
        
        $result = [];
        
        foreach ($data as $item) {
            $file = self::find($item['id']);
            
            if (fnmatch($filter, $item['file'])) {
                array_push($result, $file->get());
            }
            unset($file);
            
        }
            
        return $result;
    }





}