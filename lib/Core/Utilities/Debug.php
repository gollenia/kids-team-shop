<?php
namespace Contexis\Core\Utilities;

/**
 * Utility Class with various static functions
 * 
 * @since 1.0.0
 */

class Debug {

    /**
     *  Cast any variable into the Browser Javascript Console. Better way to analyze arrays than var_dump.
     * 
     * @since 1.0.0
     * 
     * @param array $value or variable to log
     * @param bool $in_header put output into header to prevent multiple header-difinitions 
     * 
     */
    public static function to_browser_console($value = "nothing to debug") {
        
        global $conf;

        if($conf['allowdebug'] === 1) {
            echo "<script>console.log(" . json_encode($value) . ");</script>";
        }

    }


    /**
     * Merge contents from one associtative array to another
     *
     * @param array $to
     * @param array $from
     * @param bool  $clobber
     */
    public static function mergeAssocArray($to, $from, $clobber = true)
    {
        if ( is_array($from) ) {
            foreach ($from as $k => $v) {
                if (!isset($to[$k])) {
                    $to[$k] = $v;
                } else {
                    $to[$k] = self::mergeAssocArray($to[$k], $v, $clobber);
                }
            }

            return $to;
        }

        return $clobber ? $from : $to;
    }

    static function is_natural($str)
    {
        return preg_match('/[^0-9]+$/', $str) ? false : $str;
    }


    static function string_to_array_by_delimiter($delimiter, $string){

    }

    static function string_to_array_field_by_delimiter(){
        
    }
    
}