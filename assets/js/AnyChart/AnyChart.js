var anychart = require('anychart');

export default class  {
    init() {
        var chart = anychart.bar();
        var data = JSON.parse(rates.dataset.rates);
        var dataToMiniArrays = Object.keys(data).map(function (key) {
            return [String(key), data[key]];
        });
        var series = chart.bar(dataToMiniArrays);
        chart.barGroupsPadding(0);

        chart.container('chart');
        chart.draw();
    }
}
