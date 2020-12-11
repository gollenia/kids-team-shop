<?php

namespace Contexis\Twig;

use Twig\TwigFunction;

class CustomFunctions {

    public function __construct($twig)
    {
        $twig->addFunction(new TwigFunction(
            $this->name, 
            [$this, "render"], 
            ['is_safe' => ['html']]
        ));
    }

    public static function register($twig) {

        $files = scandir(tpl_incdir() . '/lib/Twig/Functions');

        if (!$files) { return; }
        
		foreach($files as $file) {

			if ("php" === pathinfo($file, PATHINFO_EXTENSION)) {
                require_once(tpl_incdir() . '/lib/Twig/Functions/' . $file);
                $class = "Contexis\\Twig\\Functions\\" . substr($file, 0, -4);
                $instance = new $class($twig);
			}
		}
    }
}