import "./bootstrap";
import "../css/app.css";

import {createApp, h} from "vue";
import {createInertiaApp, Link} from "@inertiajs/vue3";
import {resolvePageComponent} from "laravel-vite-plugin/inertia-helpers";
import {ZiggyVue} from "../../vendor/tightenco/ziggy";

import {createI18n} from "vue-i18n";
import ru from "../../lang/ru.json";
import en from "../../lang/en.json";

// Plugins

import {registerPlugins} from "@/Plugins";

const appName = import.meta.env.VITE_APP_NAME || "MyStore";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({el, App, props, plugin}) {
        const i18n = createI18n({
            legacy: false,
            locale: props.initialPage.props.locale ? props.initialPage.props.locale : 'en' , // user locale by props
            fallbackLocale: "en", // set fallback locale
            messages: {ru, en},
        });

        return createApp({render: () => h(App, props)})
            .use(plugin)
            .use(ZiggyVue)
            .use(i18n)
            .component("Link", Link)
            .use(registerPlugins)
            .mount(el);
    },
    progress: {
        color: "rgb(216 180 254)",
    },
});
