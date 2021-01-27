<?php
namespace Contexis\Controllers;

class Page {

	public function get() {
        global $INPUT;

		$id = $INPUT->str('id', 'none');
		
		if(auth_quickaclcheck($id) < AUTH_READ){
            header('HTTP/1.0 403 Forbidden');
            return;
        }
        
		if (page_exists($id, $rev='', $clean=true, $date_at=false)) {
			$content = p_wiki_xhtml($id, $rev, false);
			return json_encode($content);
		}
		
		else {
			header("HTTP/1.0 404 Not Found");
			
		}
		
	}
	
	public function raw() {
        global $INPUT;

		$id = $INPUT->str('id', 'none');
		
        if(auth_quickaclcheck($id) < AUTH_READ){
            header('HTTP/1.0 403 Forbidden');
            return;
        }
        $text = rawWiki($id);
        $title = p_get_metadata($id, 'title');
        $tags = p_get_metadata($id, 'subject');
        if(!$text) {
            $data = array($id);
            header("HTTP/1.0 404 Not Found");
            return;
        } else {
            return json_encode([
                'title' => $title,
                'text' => $text,
                'tags' => $tags
            ]);
        }
    }
    
    public function exists() {
        global $INPUT;
        
    	$id = $INPUT->str('id', '');
    	if (page_exists($id, $rev='', $clean=true, $date_at=false)) {
			return json_encode(true);
		} else {
			return json_encode(false);
		}
    }
	
	public function save() {
        global $TEXT;
        global $lang;
        global $conf;
        global $INPUT;

        $id    = cleanID($INPUT->str('id', 'none'));
        $TEXT  = cleanText($INPUT->str('text'));
        $sum   = $INPUT->str('sum', '');
        $minor = $INPUT->str('minor', '');

        if(!page_exists($id) && trim($TEXT) == '') {
            return;
        }

        if(auth_quickaclcheck($id) < AUTH_EDIT) {
        	header('HTTP/1.0 403 Forbidden');
            return;
        }

        if(checklock($id)) {
            header('HTTP/1.0 423 Locked');
            return;
        }

        lock($id);
		saveWikiText($id,$TEXT,$sum,$minor);
        unlock($id);
        
        $tags = cleanText($INPUT->str('tags'));
        $meta_subject = explode(',', $tags);
        p_set_metadata($id, ['subject' => $meta_subject]);

        return json_encode(true);
    }
}