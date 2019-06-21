export default class Application {
    start() {
        if ('loading' === document.readyState) {
            document.addEventListener('DOMContentLoaded', () => Application.onDomReady());

            return;
        }

        Application.onDomReady();
    }

    static onDomReady() {

    }
}
