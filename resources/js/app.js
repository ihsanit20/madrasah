require('./bootstrap');

import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import axios from 'axios';
import { createApp, h } from 'vue';

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
                } 
            })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
