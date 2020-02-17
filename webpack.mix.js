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
   .sass('resources/sass/app.scss', 'public/css');

mix.styles([
    'public/pagina/css/bootstrap.min.css',
    'public/pagina/css/style.css',
    'public/pagina/css/responsive.css',
    'public/pagina/css/svg.css',
    'public/pagina/css/themify-icons.css',
    'public/pagina/css/portfolio.css',
    'public/pagina/css/owlslider.css',
    'public/pagina/css/sb-admin.css',
    'public/pagina/css/font-awesome.css',
    'public/pagina/css/font-awesome.min.css',
    'public/pagina/assets/owlcarousel/assets/owl.carousel.min.css',
    'public/pagina/assets/owlcarousel/assets/owl.theme.default.min.css',
], 'public/css/pagina.css'),
mix.scripts([
    'public/pagina/js/jquery.min.js',
    'public/pagina/vendor/bootstrap/js/bootstrap.bundle.min.js',
    'public/pagina/vendor/jquery-easing/jquery.easing.min.js',
    'public/pagina/js/sb-admin.min.js',
    'public/pagina/js/portfolio.js',
    'public/pagina/js/you-listing.js',
    'public/pagina/js/menurght.js',
    'public/pagina/js/crausal1.js',
    'public/pagina/js/slick.min.js',
    'public/pagina/assets/vendors/jquery.min.js',
    'public/pagina/assets/owlcarousel/owl.carousel.js',
    'public/pagina/assets/vendors/highlight.js',
    'public/pagina/assets/js/app.js'
], 'public/js/pagina.js').version();

mix.scripts([
    'public/assets/node_modules/jquery/jquery-3.2.1.min.js',
    'public/assets/node_modules/popper/popper.min.js',
    'public/assets/node_modules/bootstrap/dist/js/bootstrap.min.js',
    'public/js/perfect-scrollbar.jquery.min.js',
    'public/js/waves.js',
    'public/js/sidebarmenu.js',
    'public/js/custom.js',
    'public/assets/node_modules/raphael/raphael-min.js',
    'public/assets/node_modules/jquery-sparkline/jquery.sparkline.min.js'
 ], 'public/js/intranet.js').version();




