var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('main', './assets/js/main.js')
    .addEntry('dataTables', './assets/js/DataTables/DataTables.js')
    .addEntry('anyChart', './assets/js/AnyChart/AnyChart.js')
    .addEntry('anyChartSingle', './assets/js/AnyChart/AnyChartSingle.js')
    .addEntry('dataTablesSingle', './assets/js/DataTables/DataTablesSingle.js')
    .disableSingleRuntimeChunk()
    .enableSassLoader()
    .enablePostCssLoader()
;

module.exports = Encore.getWebpackConfig();
