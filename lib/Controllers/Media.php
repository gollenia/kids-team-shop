<?php
namespace Contexis\Controllers;

class Media {

	function upload() {
		global $INPUT;
		global $_FILES;
		$id = $INPUT->str('id', 'none');
	    $auth = auth_quickaclcheck(getNS($id).':*');
	    
	    if($auth < AUTH_UPLOAD) { 
	    	return json_encode(array('status' => 403, 'error' => 'Keine Berechtigung"'));
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

	function tree($ns = '') {
		global $conf;

		$data = [];
		search($data, $conf['mediadir'], 'search_index', array('ns' => $ns, 'nofiles' => true));
		
		$items = [];
		foreach($data as $match) {
			if ($match['ns'] == $ns) {
				$item = [
					'id' => $match['id'],
					'ns' => $match['ns']
				];
				$children = $this->tree($match['id']);
				if ($children) {
					$item['children'] = $children;
				}
				$items[] = $item;
			}
		}

		if ($ns !== '') {
			return $items;
		} else {
			return json_encode([
				'tree' => [
					[
						'id' => '',
						'children' => $items
					]
				]
			]);
		}
	}
	
	function list() {
	    global $conf;
			global $lang;
			global $INPUT;
	    
			$ns = cleanID($id = $INPUT->str('ns', 'none'));
	
	    // check auth our self if not given (needed for ajax calls)
	    if(is_null($auth)) $auth = auth_quickaclcheck("$ns:*");
	
	    
	    if($auth < AUTH_READ){
	        // FIXME: print permission warning here instead?
	        echo "Keine Berechtigung";
	    }else{

	
	        $dir = utf8_encodeFN(str_replace(':','/',$ns));
	        $data = array();
	        search($data,$conf['mediadir'],'search_media',
	                array('showmsg'=>false,'depth'=>1),$dir,1,$sort);
	            
	        echo json_encode($data);
	  
	    }
	}

	function first() {
			global $conf;
			global $INPUT;
	    
	    $id = $INPUT->str('id', 'none');
	    $references = p_get_metadata($id, 'relation');
	    $image = $references['firstimage'];
	    return json_encode($references);
	    
	}
	
	public function delete() {
		global $INPUT;

		$id = $INPUT->str('id', 'none');
        $auth = auth_quickaclcheck(getNS($id).':*');
        if($auth < AUTH_DELETE) return new IJR_ERROR(1, "You don't have permissions to delete files.");
        global $conf;
        global $lang;

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