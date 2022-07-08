const mix = require('laravel-mix');

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
mix.js('resources/js/app.js', 'public/js')
    .vue()
    .js("resources/js/vanilla/app.js", "public/dist/js/vanilla.js")
    .css("public/dist/css/_app.css", "public/dist/css/app.css")
    .options({
        processCssUrls: false,
    })
    .sourceMaps()
    .version();
