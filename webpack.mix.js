let mix = require('laravel-mix');

mix.js('resources/js/main.js', 'public/js')
    .postCss('resources/css/main.css', 'public/css', [
        require('tailwindcss'),
    ]);

mix.js('resources/vue/app.js', 'public/js').vue();
