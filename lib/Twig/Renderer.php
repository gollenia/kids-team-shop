<?php

namespace Contexis\Twig;

use Contexis\Twig\CustomFunctions;
use Contexis\Twig\Colors;

use Twig\{
    Loader\FilesystemLoader,
    Environment
};


class Renderer {
    static function compile($filenames, $data, $options = []) {
        $loader = new FilesystemLoader(tpl_incdir() . './templates');
        $twig = new Environment($loader, $options);
        CustomFunctions::register($twig);
        Colors::add_twig_filter($twig);
        return $twig->render($filenames, $data);
    }

    static function compile_string(string $template, array $data) {
        $loader = new \Twig\Loader\ArrayLoader([
            'index.html' => $template,
        ]);
        $twig = new Environment($loader);
        return $twig->render('index.html', $data);
    }
}