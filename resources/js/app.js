import "./bootstrap";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import Layout from "./components/Layout.vue";
import Main from "./layout/Main.vue";

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./pages/**/*.vue", { eager: true });
        let page = pages[`./pages/${name}.vue`];

        page.default.layout = page.default.layout || Main;

        return page;
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
