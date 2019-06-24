import DataTables from "./DataTables/DataTables";
import '../css/main.scss'

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
    }
}
