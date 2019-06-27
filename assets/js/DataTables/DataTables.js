let $ = require('jquery');
var dt = require('datatables.net');
window.JSZip = require( "jszip" );
require( 'datatables.net-buttons/js/buttons.html5.js' );

var table = $('#rates').DataTable({
    ajax: {
        url: 'https://openexchangerates.org/api/latest.json\?app_id=4d4619793dce4220954dc2a1212235fc',
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
