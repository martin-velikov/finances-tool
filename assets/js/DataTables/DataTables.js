let $ = require('jquery');
var dt = require('datatables.net');
window.JSZip = require( "jszip" );
require( 'datatables.net-buttons/js/buttons.html5.js' );

export default class {
    init() {
        $('#rates').DataTable({
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
        } );
    }
}
