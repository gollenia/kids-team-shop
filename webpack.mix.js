let mix = require('laravel-mix');

mix.js('resources/js/main.js', 'public/js')
    .postCss('resources/css/main.css', 'public/css', [
        require('tailwindcss'),
        require('autoprefixer')
    ]);

mix.js('resources/js/editor.js', 'public/js').vue();
