let mix = require('laravel-mix')

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.autoload({
        'jquery': ['$', 'window.jQuery'],
        'popper.js': ['Popper']
    }).copyDirectory('node_modules/font-awesome/fonts', 'public/fonts')
    .js('resources/assets/main.js', 'public/js')
    .sass('resources/assets/sass/main.scss', 'public/css')
    .extract(['vue', 'vuex', 'jquery', 'bootstrap', 'xlsx', 'urijs', 'popper.js', 'vuejs-paginate'])

if (mix.inProduction()) {
    mix.version()
}
