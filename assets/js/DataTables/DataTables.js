let $ = require('jquery');
var dt = require('datatables.net');
window.JSZip = require( "jszip" );
require( 'datatables.net-buttons/js/buttons.html5.js' );

var table = $('#rates').DataTable({
    ajax: {
        url: 'https://openexchangerates.org/api/latest.json\?app_id=0f84f49980364d2abceff8f276d4f58b',
        dataSrc: function(data){
            let apiData = [];
            $.each(data.rates, function(index, entry){
                apiData.push({currency:index, rate:entry});
            });

            return apiData;
        },
    },
    columns: [
        { title: 'Currency', data: 'currency'},
        { title: 'Rate', data: 'rate'},
        ],
    dom: 'Bfrtip',
    buttons: [
        {
            extend: 'csv',
            title: 'Exchange rates'
        },
        {
            extend: 'excel',
            title: 'Exchange rates'
        },
    ],
    "searching": false,
});
