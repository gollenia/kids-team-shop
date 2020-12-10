<?php
/**
 * Additional twig-functions for working with colors. Utilizes OzdemirBuraks Color-Tools
 * 
 * @since 1.0.0
 * @link https://github.com/ozdemirburak/iris
 */

namespace Contexis\Twig;
use Twig\TwigFilter;
use Twig\TwigFunction;
use OzdemirBurak\Iris\Color\Hex;

class Colors {
    public static function add_twig_filter($twig)
    {
        $twig->addFilter( new TwigFilter( 'darken', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->darken($percent);
        } ) );
        $twig->addFilter( new TwigFilter( 'lighten', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->lighten($percent);
        } ) );
        $twig->addFilter( new TwigFilter( 'tint', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->tint($percent);
        } ) );
        $twig->addFilter( new TwigFilter( 'shade', function( $color, $percent ) {
            $hex = new Hex($color);
            return $hex->shade($percent);
        } ) );
        $twig->addFunction( new TwigFunction( 'isLight', function( $color ) {
            $hex = new Hex($color);
            return $hex->isLight();
        } ) );
        $twig->addFunction( new TwigFunction( 'isDark', function( $color ) {
            $hex = new Hex($color);
            return $hex->isDark();
        } ) );

        return $twig;
    }
}