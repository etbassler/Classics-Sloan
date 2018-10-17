/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your application.
 |
 */

let mix = require('laravel-mix');
let CopyWebpackPlugin = require('copy-webpack-plugin');
let { default: ImageminPlugin } = require('imagemin-webpack-plugin');
let imageminMozjpeg = require('imagemin-mozjpeg');

const src = 'assets';
const dist = 'dist';
const proxy_host = ''; // Proxy an existing virtual host. (ex: 'https://local.dev')

mix
  .options({
    processCssUrls: false
  })
  .setPublicPath(`${dist}`)
  .setResourceRoot('./')
  .webpackConfig({
    plugins: [
      // Copy and minify image assets.
      new CopyWebpackPlugin([
        {
          from: `${src}/images`,
          to: 'images'
        }
      ]),
      new ImageminPlugin({
        optipng: { optimizationLevel: 7 },
        gifsicle: { optimizationLevel: 3 },
        pngquant: { quality: '65-90', speed: 4 },
        svgo: { removeUnknownsAndDefaults: false, cleanupIDs: false },
        plugins: [imageminMozjpeg({ quality: 80 })]
      })
    ]
  });

// Sass
mix.sass(`${src}/styles/main.scss`, `${dist}/styles`);

// JavaScript
mix
  .js(`${src}/scripts/main.js`, `${dist}/scripts`)
  .js('node_modules/jquery/dist/jquery.js', `${dist}/scripts`)
  .autoload({
    jquery: ['$', 'window.jQuery', 'jQuery']
  });

// Browsersync
if (proxy_host) {
  mix.browserSync({
    files: ['dist/styles/**/*.css', 'dist/scripts/**/*.js'],
    notify: true,
    proxy: proxy_host
  });
}

// Source maps when not in production.
if (!mix.inProduction()) {
  mix.sourceMaps();
}

// Hash and version files in production.
if (mix.inProduction()) {
  mix.version();
}
