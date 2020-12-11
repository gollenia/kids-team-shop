<?php

namespace Contexis\Core\Utilities;

use FFI\Exception;

class Strings {
    static function to_array_field($string, $delimiter = "-", $max) {

        $start_stop = explode($delimiter, $string);
        
        $start = intval($start_stop[0]);
        $end = intval(end($start_stop));

        if($start > $end) {
            throw new Exception("Error: Start must not be bigger than end");
        }

        $array_field = [];
        for($i = $start; $i < $end + 1; $i++) {
            array_push($array_field, $i);
        }

        return $array_field;
    }

}