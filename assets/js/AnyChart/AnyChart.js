var anychart = require('anychart');

$.ajax({
    url: "https://openexchangerates.org/api/latest.json?app_id=0f84f49980364d2abceff8f276d4f58b",
    data: { rates: "rates" },
    success: function(data){
        let dataToMiniArrays = Object.keys(data.rates).map(function (key) {
            return [String(key), data.rates[key]];
        });
        let chart = anychart.bar();
        let series = chart.bar(dataToMiniArrays);
        chart.container('chart');
        chart.draw();
    }
});
