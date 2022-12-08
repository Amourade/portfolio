import "./bootstrap";
import "../css/app.scss";

import { createApp, h } from "vue";
import { createInertiaApp, Head, Link } from "@inertiajs/inertia-vue3";
//import { InertiaProgress } from "@inertiajs/progress";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { Vue3Mq } from "vue3-mq";
import { createManager } from "@/plugins/@vue-youtube/core";
import moveable from "@/plugins/movable-elements/moveable";
const appName =
    window.document.getElementsByTagName("title")[0]?.innerText ||
    "Antoine Thériault";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(moveable)
            .use(ZiggyVue, Ziggy)
            .use(Vue3Mq, {
                breakpoints: {
                    sm: 0,
                    lg: 768,
                },
            })
            .use(createManager())
            .component("Link", Link)
            .component("Head", Head)
            .mount(el);
    },
});
