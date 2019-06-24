import DataTables from "./DataTables/DataTables";
import '../css/main.scss'
import AnyChart from "./AnyChart/AnyChart";

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
