<?php
/**
 * Class loading config files. When an Instance is loaded, every PHP and JSON file in a
 * given directory is loaded into the object
 * 
 * @since 1.0.0
 */

namespace Contexis\Core;

use Exception;

class Config {
    
    private $config = array();

    /**
     * Constructor sets up the Config Object from an Array, wich is stored
     * i a given file
     * 
     * @param string $config_path path where config files can be found
     * @param array $files Instead of scanning the directory, only use the files given in this array
     * @since 1.0.0
     */
    public function __construct(string $config_path, array $files = []) {

        
        if (empty($files)) {
            
            $files = scandir($config_path);
            foreach($files as $file) {

                if ("json" === substr($file, -4)) {
                    $setting = substr($file, 0, -5);
                    $string = file_get_contents($config_path . $file);
                    $this->config[$setting] = json_decode($string, true);
                }
                
                if ("php" === substr($file, -3)) {
                    $setting = substr($file, 0, -4);
                    $this->config[$setting] = require_once($config_path . $file);
                }
            }
            return;
        }

        foreach($files as $file) {
            if (file_exists($config_path . $file . ".json")) {
                $string = file_get_contents($config_path . $file . ".json");
                $this->config[$file] = json_decode($string, true);
            }
            
            if (file_exists($config_path . $file . ".php")) {
                $this->config[$file] = require_once($config_path . $file . ".php");
            }
        }
        
        
    }

    /**
     * Retrieve a config value or sub array
     * 
     * Configs can be called with dot notation like $config->get("foo.bar")
     * 
     * @param string Config key in dot notation
     * @return mixed Config value
     * @since 1.0.0
     */
    public function get( $string = "")
    {
        if ($string === "") {
            return $this->config;
        }

        $keys = explode( '.', strval( $string ) );
        $movingTarget = $this->config;
        
        foreach ( $keys as $key )
        {
            $isArray = is_array( $movingTarget ) || $movingTarget instanceof \ArrayAccess;
            if ( ! $isArray || ! isset( $movingTarget[ $key ] ) ) return NULL;
            
            $movingTarget = $movingTarget[ $key ];
        }
        
        return $movingTarget;
    }

    /**
     * Set config value or array
     * 
     * @param $key key of config
     * @param mixed $value whatever to store at the key
     * @return void
     * @todo ability to add values at subkey with dot-notation
     * @since 1.0.0
     */
    public function set($key, $value) {
        $this->config[$key] = $value;
    }


    public static function load(string $file) {
        
        $config_path = tpl_incdir() . "conf/";


        if (file_exists ( $config_path . $file . ".json" )) {
            $json = file_get_contents($config_path . $file);
            return json_decode($json, true);
        }

        if (file_exists ( $config_path . $file . ".php" )) {
            return include($config_path . $file . ".php");
        }

        throw new Exception("Config file " . $config_path . $file . ".php not found!");

        
    }

}