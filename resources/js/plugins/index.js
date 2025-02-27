/**
 * plugins/index.ts
 *
 */

import PrimeVue from "primevue/config";
import ToastService from "primevue/toastservice";
import { definePreset } from '@primeuix/themes';
import {createPinia} from "pinia";
import Aura from '@primeuix/themes/aura';

const pinia = createPinia();

const MyPreset = definePreset(Aura, {
    semantic: {
        primary: {
            50: '{indigo.50}',
            100: '{indigo.100}',
            200: '{indigo.200}',
            300: '{indigo.300}',
            400: '{indigo.400}',
            500: '{indigo.500}',
            600: '{indigo.600}',
            700: '{indigo.700}',
            800: '{indigo.800}',
            900: '{indigo.900}',
            950: '{indigo.950}'
        }
    }
});

export function registerPlugins(app) {
    app.use(PrimeVue, {
        theme: {
            preset: MyPreset,
            options: {
                darkModeSelector: '.my-store-dark',
                cssLayer: {
                    name: 'primevue',
                    order: 'tailwind-base, primevue, tailwind-utilities'
                }
            }
        }
    })
        .use(ToastService)
        .use(pinia);
}
