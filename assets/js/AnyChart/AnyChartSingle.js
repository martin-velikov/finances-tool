var anychart = require('anychart');

let data = JSON.parse(rates.dataset.rates);
let dataToMiniArrays = Object.keys(data).map(function (key) {
    return [String(key), data[key]];
});

let chart = anychart.bar();
let series = chart.bar(dataToMiniArrays);
chart.container('chart');
chart.draw();
