import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import '@fortawesome/fontawesome-free/css/all.css';
import Layout from "./Shared/Layout.vue";

createInertiaApp({
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    // resolve: name => {
    //     console.log(`/Pages/${name}.vue`);
    //     const page = require(`js/Pages/${name}.vue`).default
    //     console.log(page);
    //     page.layout = Layout
    //     return page
    // },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin({methods: {route: window.route}})
            .mount(el);
    }
});
