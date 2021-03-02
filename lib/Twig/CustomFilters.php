<?php
namespace Contexis\Twig;

use Twig\TwigFilter;

class CustomFilters {

    public function __construct($twig)
    {
        $twig->addFilter(new TwigFilter(
            $this->name, 
            [$this, "render"], 
            ['is_safe' => ['html']]
        ));
    }

    public static function register($twig) {

        $files = scandir(tpl_incdir() . '/lib/Twig/Filters');

        if (!$files) { return; }
        
		foreach($files as $file) {

			if ("php" === pathinfo($file, PATHINFO_EXTENSION)) {
                require_once(tpl_incdir() . 'lib/Twig/Filters/' . $file);
                $class = "Contexis\\Twig\\Filters\\" . substr($file, 0, -4);
                $instance = new $class($twig);
			}
		}
    }
}