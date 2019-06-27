var anychart = require('anychart');

$.ajax({
    url: "https://openexchangerates.org/api/latest.json?app_id=4d4619793dce4220954dc2a1212235fc",
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
