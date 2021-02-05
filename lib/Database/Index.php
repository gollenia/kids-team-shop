<?php
namespace Contexis\Database;

define('CATLIST_DISPLAY_LIST', 1);
define('CATLIST_DISPLAY_LINE', 2);

define('CATLIST_NSLINK_AUTO', 0);
define('CATLIST_NSLINK_NONE', 1);
define('CATLIST_NSLINK_FORCE', 2);

define('CATLIST_INDEX_START', 0);
define('CATLIST_INDEX_OUTSIDE', 1);
define('CATLIST_INDEX_INSIDE', 2);

define('CATLIST_SORT_NONE', 0);
define('CATLIST_SORT_ASCENDING', 1);
define('CATLIST_SORT_DESCENDING', 2);

 
class Index {

    public $startpages = ["start"];
	
	public function cleanID($ajax) {
		$id = $ajax->str('id', 'none');
		return json_encode(cleanID($id));
	}
	
	
    public function get() {
        global $conf;
        global $INPUT;
		$id = $INPUT->str('id', ':');
        
        $data = array();
		$id = str_replace(':', "/", $id);
        
        search($data,$conf['datadir'],array($this,'_search'),array(),$id,1,'natural');
        
        foreach($data as $key => $value) {
        		$data[$key]['meta'] = p_get_metadata($value['id']);
        }
        
        return $data;
    }
    
    /**
     * Build tree for navigation purposes
     *
     * @param string $namespace Where to start from
     * @param string $excludes Comma separated list of namespaces to exclude
     * @param boolean $excludePages Exclude Pages and only show Dirs
     * @return array NEsted array with Site Tree
     */
    public function tree($namespace = "", $excludes = "", $excludePages = false) {
        $data = [];
    	$r = $this->_walk($data, $namespace, $excludes, $excludePages);
    	return $data;
    }
    
    
    function _search(&$data,$base,$file,$type,$lvl,$opts){
        global $conf;
        $this->counter++;
        $return = true;
        $item = array();
        $id = pathID($file);
        if($type == 'd' && !(
            preg_match('#^'.$id.'(:|$)#',$opts['ns']) ||
            preg_match('#^'.$id.'(:|$)#',getNS($opts['ns']))
        )){
            //add but don't recurse
            $return = false;
        }elseif($type == 'f' && (!empty($opts['nofiles']) || substr($file,-4) != '.txt')){
            //don't add
            return false;
        }
        if($type=='d' && $conf['sneaky_index'] && auth_quickaclcheck($id.':') < AUTH_READ){
            return false;
        }
        if($type == 'd'){
            // link directories to their start pages
            $exists = false;
            $id = "$id:";
            resolve_pageid('',$id,$exists);
            $this->startpages[$id] = 1;
        }elseif(!empty($this->startpages[$id])){
            // skip already shown start pages
            return false;
        }elseif(noNS($id) == $conf['start']){
            // skip the main start page
            return false;
        }
        //check hidden
        if(isHiddenPage($id)){
            return false;
        }
        //check ACL
        if($type=='f' && auth_quickaclcheck($id) < AUTH_READ){
            return false;
        }
        $meta = p_get_metadata($id);
        
        if ($meta['title'] == null) {
        	$title = $meta['extras']['title'];
        } else {
        	$title = $meta['title'];
        }
        array_push ( $data , array( 
        	'id'    => $id,
            'type'  => $type,
            'level' => $lvl,
            'extras' => $meta['extras'],
            'title' => $title,
            'open'  => $return) );
        $data['meta'] = array();
        return $return;
    }
    
    function _isExcluded ($item, $exclutype, $arrayRegex, $exclusions = false) {
		if ($arrayRegex === true) return true;
		global $conf;
		if ((strlen($conf['hidepages']) != 0) && preg_match('/'.$conf['hidepages'].'/i', $item['id'])) return true;
		if (is_array($arrayRegex)) foreach($arrayRegex as $regex) {
			if (preg_match('/'.$regex.(($exclutype=='title')?'/':'/i'), $item[$exclutype])) {
				return true;
			}
        }
        
        if ($exclusions) {
            $exclusion_array = explode(",", $exclusions);
            foreach ($exclusion_array as $exclusion) {
                if ($exclusion == $item['id'])  {
                    
                    return true;
                }
            }
        }
        
		return false;
	}

	function _getStartPage ($index_priority, $parid, $parpath, $name, $force, &$exists) {
		$exists = false;
		if ($parid != '') $parid .= ':';
		global $conf;
		$index_path_map = array( CATLIST_INDEX_START => $parpath.'/'.$name.'/'.$conf['start'].'.txt',
		                         CATLIST_INDEX_OUTSIDE => $parpath.'/'.$name.'.txt',
		                         CATLIST_INDEX_INSIDE => $parpath.'/'.$name.'/'.$name.'.txt' );
		$index_id_map = array( CATLIST_INDEX_START => $parid .$name.':'.$conf['start'],
		                       CATLIST_INDEX_OUTSIDE => $parid .$name,
		                       CATLIST_INDEX_INSIDE => $parid .$name.':'.$name );
		if (is_array($index_priority)) foreach ($index_priority as $index_type) {
			if (is_file($index_path_map[$index_type])) {
				$exists = true;
				return $index_id_map[$index_type];
			}
		}
		if ($force && isset($index_priority[0])) 
			return $index_id_map[0];
		else
			return false;
	}

	function _walk (&$data, $ns, $exclusions = "", $excluPages = false) {
		global $conf;
			// Prepare
		$ns = $data['ns'];
        
		$path = $conf['savedir'].'/pages/'.str_replace(':', '/', $ns);
		$path = utf8_encodeFN($path);
		if (!is_dir($path)) {
			msg(sprintf($this->getLang('dontexist'), $ns), -1);
			return false;
		}
			// Main page
		$main = array( 'id' => $ns.':',
		               'exist' => false,
		               'title' => NULL );
		resolve_pageid('', $main['id'], $main['exist']);
			
		$main['title'] = p_get_first_heading($main['id'], true);
		if (is_null($main['title']))
				$main['title'] = end(explode(':', $ns));
		
		$data['main'] = $main;
			// Recursion
		$data['tree'] = array();
		$data['index_pages'] = array( $main['id'] );
		$this->_walk_recurse($data, $path, $exclusions, $ns, $excluPages, false, 1, $data['maxdepth'], $data['tree'], $data['index_pages']);
		return true;
	}

	function _walk_recurse (&$data, $path, $exclusions = "", $ns, $excluPages, $excluNS, $depth, $maxdepth, &$_TREE) {
		$scanDirs = @scandir($path, $data['scandir_sort']);
		if ($scanDirs === false) {
			msg("catlist: can't open directory of namespace ".$ns, -1);
			return;
		}
		foreach ($scanDirs as $file) {
            
			if ($file[0] == '.' || $file[0] == '_') continue;
			$name = utf8_decodeFN(str_replace('.txt', '', $file));
            $id = ($ns == '') ? $name : $ns.':'.$name;
            
			$item = array('id' => $id, 'name'  => $name, 'title' => NULL);
				// It's a namespace
			if (is_dir($path.'/'.$file)) {
                    // Index page of the namespace
                
				$index_exists = false;
				$index_id = $this->_getStartPage($data['index_priority'], $ns, $path, $name, ($data['nsLinks']==CATLIST_NSLINK_FORCE), $index_exists);
				if ($index_exists)
					$data['index_pages'][] = $index_id;
					// Exclusion
                if ($excluNS) continue;
                
                if ($this->_isExcluded($item, $data['exclutype'], $data['excluns'], $exclusions)) continue;
					// Namespace
                
                $item['startpage'] = false;
                $item['title'] = p_get_first_heading($id, true);
                if(page_exists($id . ':start')) {
                    $item['startpage'] = true;
                    $item['title'] = p_get_first_heading($id . ":start", true);
                }
				
				if (is_null($item['title']))
					$item['title'] = ucfirst(end(explode(":", $id)));
				$item['folder'] = true;
					// Button
				$item['buttonid'] = $data['createPageButtonSubs'] ? $id.':' : NULL;
					// Recursion if wanted
				$item['children'] = array();
				$okdepth = ($depth < $maxdepth) || ($maxdepth == 0);
				if (!$this->_isExcluded($item, $data['exclutype'], $data['exclunsall']) && $okdepth) {
					$exclunspages = $this->_isExcluded($item, $data['exclutype'], $data['exclunspages']);
					$exclunsns = $this->_isExcluded($item, $data['exclutype'], $data['exclunsns']);
					$this->_walk_recurse($data, $path.'/'.$file, $exclusions, $id, $exclunspages, $exclunsns, $depth+1, $maxdepth, $item['children']);
				}
					// Tree
				$_TREE[] = $item;
			} else 
				// It's a page
			if (!$excluPages) {
                
                if ($file == "start.txt") { continue; }
                if (substr($file, -4) != ".txt") continue;
					// Page title
				
					$title = p_get_first_heading($id, true);
					if (!is_null($title))
						$item['title'] = $title;
				
				if (is_null($item['title']))
					$item['title'] = $name;
					// Exclusion
				if ($this->_isExcluded($item, $data['exclutype'], $data['exclupage'])) continue;
                    // Tree
                 
                $item['folder'] = false;
                if($name == "start") {$item['folder'] = true;}  
				if (strcmp(end($_TREE)['id'], $item['id']) !== 0) {
					$_TREE[] = $item;
				}
				
			}
		}
	
}



}
















