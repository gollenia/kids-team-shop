<?php
namespace Contexis\Controllers;
use \dokuwiki\Input\Input;
use \Contexis\Models\Page;
use \Contexis\Models\File;


class Media {

	function ajax_upload($response) {
		$file = File::create($response->str('id', ':'));
		return json_encode($file);
	}

	function ajax_token($response) {
		return json_encode(getSecurityToken());
	}
	
	function ajax_list($request) {
	    global $conf;
	    
		$ns = cleanID($request->str('ns', 'none'));
		$filter = $request->str('filter', '*.*');
	
	    return json_encode(File::findAllByWildcard($ns, $filter));
	}

	function ajax_get ($request) {
		$file = File::find($request->str('id', ''));
		return json_encode($file->get());
	}

	function ajax_first() {
			global $conf;
			global $INPUT;
	    
	    $id = $INPUT->str('id', 'none');
	    $references = p_get_metadata($id, 'relation');
	    $image = $references['firstimage'];
	    return json_encode($references);
	    
	}

	public function ajax_tree(Input $request) {
        $id = $request->str($id = ""); 
        $pageTree = Page::findAll($id, true, "bibel,system");
        return json_encode($pageTree);
    }
	
	public function ajax_delete($id) {
		$file = File::find($id);
		$file->delete();
	}
	
}