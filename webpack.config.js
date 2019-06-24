var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('main', './assets/js/main.js')
    .addEntry('dataTables', './assets/js/DataTables/DataTables.js')
    .disableSingleRuntimeChunk()
    .enableSassLoader()
;

module.exports = Encore.getWebpackConfig();
