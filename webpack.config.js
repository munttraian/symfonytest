const { VueLoaderPlugin } = require('vue-loader');

var Encore = require('@symfony/webpack-encore'); 
Encore
   .setOutputPath('public/build/')
   .setPublicPath('/build')
   .cleanupOutputBeforeBuild()
   .enableSourceMaps(!Encore.isProduction())
   .addEntry('js/app', './assets/js/app.js')
   .addStyleEntry('css/app', './assets/css/volumes.css')
   // .enableSassLoader()
   // .autoProvidejQuery()
  
   // Enable Vue loader
   .enableVueLoader()
;
 
let config = Encore.getWebpackConfig();

config.plugins.push(new VueLoaderPlugin());

module.exports = config;