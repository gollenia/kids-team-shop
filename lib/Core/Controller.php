<?php

namespace Contexis\Core;

use Contexis\Core\Site;
use Contexis\Twig\Renderer;


interface ControllerInterface {
    public function __construct(Site $site);
    public function render();
}


class Controller implements ControllerInterface {

    public Site $site;
    public $template = "default";

    public function __construct(Site $site)
    {
        $this->site = $site;
    }

    /**
     * Default renderer function
     *
     * @return string renderer result
     */
    public function render() {
        global $ACT;
        $template = $this->template;
        
        if (empty($template)) {
            $template = strtolower(end(explode("\\", get_class($this))));
        }
        
        return Renderer::compile("pages/{$template}.twig", $this->site->get());
    }

    public static function get($route, $site) {

        global $INPUT;
        

        if($INPUT->str('controller',false)) {
        
            $controllerName = ucfirst ( $INPUT->str('controller'));
            $controllerName = "Contexis\\Controllers\\" . $controllerName;
            $controller = new $controllerName($site, true);
            $method = $INPUT->str('method', 'get');
            
            if (method_exists( $controller, "ajax_" . $method)) {
                    header('Content-Type: application/json');
                    echo call_user_func_array ( array($controller, "ajax_" . $method), [$INPUT]); // , [$INPUT]
                    
            } else {
                    header('Content-Type: application/json');
                    echo "{error: 'method " . $method . " in controller " . $controllerName . " not found'}";
                    
            }
    } else {
    
            if (!class_exists($route)) {
                    //$route = "\\Contexis\\Core\\Controller";
            }
            $controller = new $route($site);
            echo $controller->render($twig);
            tpl_indexerWebBug();
    }
    
    
    }
}