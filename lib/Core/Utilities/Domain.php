<?php
namespace Contexis\Core\Utilities;


class Domain {

    /**
     *  Get TLD from URL
     * 
     * @since 1.0.0
     * 
     */
    static function get_tld() {
        $tld = strrchr ( $_SERVER['SERVER_NAME'], "." );
        return substr ( $tld, 1 );
    }
}