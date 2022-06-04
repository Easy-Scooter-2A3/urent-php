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

mix.sass('resources/sass/app.sass', 'public/css')
// Compile CSS using PostCSS
  .postCss('resources/css/tailwindcss.css', 'public/css', [
    require('tailwindcss'),
  ])
  .ts('resources/js/utils.ts', 'public/js')
  .ts('resources/js/checkRedirect.ts', 'public/js')
  .ts('resources/js/weather/canvas.ts', 'public/js')
  .ts('resources/js/admin.scooters.ts', 'public/js')
  .ts('resources/js/admin.users.ts', 'public/js')
  .ts('resources/js/admin.products.ts', 'public/js')
  .ts('resources/js/searchField.ts', 'public/js')
  .ts('resources/js/selectedRows.ts', 'public/js')
  .ts('resources/js/catalogue.ts', 'public/js')
  .ts('resources/js/panier.ts', 'public/js')
  .ts('resources/js/waypoints.ts', 'public/js')
  .ts('resources/js/user.orders.ts', 'public/js')
  .ts('resources/js/admin.partnerships.ts', 'public/js')
  .ts('resources/js/dialog.ts', 'public/js')
  .ts('resources/js/user.packages.ts', 'public/js');
