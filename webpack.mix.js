const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.ts('resources/js/app.ts', 'public/js')
    mix.sass('resources/sass/app.sass', 'public/css',)
    // Compile CSS using PostCSS
    .postCss('resources/css/tailwindcss.css', 'public/css', [
        require('tailwindcss')
    ])
    .ts('resources/js/dashboard.ts', 'public/js')
    .ts('resources/js/checkRedirect.ts', 'public/js')
    .ts('resources/js/weather-bar.ts', 'public/js');
