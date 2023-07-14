require('./bootstrap');

import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import axios from 'axios';
import { createApp, h } from 'vue';


import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import { library } from '@fortawesome/fontawesome-svg-core'

import { fas } from '@fortawesome/free-solid-svg-icons'

library.add(fas)


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ 
                methods: { 
                    route,
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
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
