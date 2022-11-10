import { createSSRApp, h } from "vue";
import { renderToString } from "@vue/server-renderer";
import { createInertiaApp, Head, Link } from "@inertiajs/inertia-vue3";
import createServer from "@inertiajs/server";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { Vue3Mq } from "vue3-mq";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import moveable from "@/plugins/movable-elements/moveable";

const appName = "Antoine Thériault";

createServer((page) =>
    createInertiaApp({
        page,
        render: renderToString,
        title: (title) => `${title} - ${appName}`,
        resolve: (name) =>
            resolvePageComponent(
                `./Pages/${name}.vue`,
                import.meta.glob("./Pages/**/*.vue")
            ),
        setup({ app, props, plugin }) {
            return (
                createSSRApp({ render: () => h(app, props) })
                    .use(plugin)
                    .use(moveable)
                    .use(ZiggyVue, {
                        ...page.props.ziggy,
                        location: new URL(page.props.ziggy.location),
                    })
                    .use(Vue3Mq, {
                        breakpoints: {
                            sm: 0,
                            lg: 768,
                        },
                    })
                    .component("Link", Link)
                    .component("Head", Head)
            );
        },
    })
);
