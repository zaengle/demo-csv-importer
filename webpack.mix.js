let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .options({
        processCssUrls: false,
        postCss: [ tailwindcss('./tailwind.js') ],
    })
    .sourceMaps()
    .extract([
        'vue',
        'lodash'
    ]);
