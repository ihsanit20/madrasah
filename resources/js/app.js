import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';

import { createInertiaApp } from '@inertiajs/vue3';

import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { library } from '@fortawesome/fontawesome-svg-core'

import { fas } from '@fortawesome/free-solid-svg-icons'

library.add(fas)

import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Muaawanah';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin({ 
                methods: {
                    $e2bnumber(position) {
                        let bengali = ["০", "১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯"];
                        position = new String(position);
                        return position.replace(/[0-9]/g, function (w) {
                            return bengali[+w];
                        });
                    },
                    $e2anumber(position) {
                        let arabic = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                        position = new String(position);
                        return position.replace(/[0-9]/g, function (w) {
                            return arabic[+w];
                        });
                    },
                } 
            })
            .component('font-awesome-icon', FontAwesomeIcon)
            .use(ZiggyVue, Ziggy)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
