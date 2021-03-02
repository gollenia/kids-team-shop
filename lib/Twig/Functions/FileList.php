<?php

namespace Contexis\Twig\Functions;

use Contexis\Twig\CustomFunctions;
use dokuwiki\Extension\Event;
use Contexis\Models\File;

/**
 * Get list of files in a given namespace
 */
class FileList extends CustomFunctions {

    public string $name = "file_list";

    public function render($id, $excludes = "") {
        
        return File::findAll($id, $excludes);
    }

}