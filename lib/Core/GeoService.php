<?php

namespace Contexis\Core;

class GeoService {
    static function get_location() {
        return var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
    }
}