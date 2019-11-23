const mix = require('laravel-mix');
const purgecss = require('@fullhuman/postcss-purgecss')({
    content: [
        './resources/views/**/*.blade.php'
    ],

    // @see https://tailwindcss.com/docs/controlling-file-size/#setting-up-purgecss
    defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
});

mix.js('resources/js/app.js', 'public/js');

mix.postCss('resources/css/app.css', 'public/css', [
    require('tailwindcss'),
    require('autoprefixer'),
    ...mix.inProduction() ? [purgecss] : []
]);

mix.copy('resources/image/avatar.jpg', 'public/image/avatar.jpg');

if (mix.inProduction()) {
    mix.version();
}
