require('bootstrap');
import '../css/main.scss'
import DataTables from "./DataTables/DataTables";
import AnyChart from "./AnyChart/AnyChart";
var $ = require("jquery");
window.$ = window.jQuery = $;

export default class Application {
    start() {
        if ('loading' === document.readyState) {
            document.addEventListener('DOMContentLoaded', () => Application.onDomReady());

            return;
        }

        Application.onDomReady();
    }

    static onDomReady() {
        new DataTables().init();
        new AnyChart().init();
    }
}
