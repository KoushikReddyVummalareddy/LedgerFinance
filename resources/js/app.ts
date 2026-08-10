import { createApp } from 'vue';
import '../css/app.css';
import '@fontsource-variable/inter';
import 'virtual:nuxt-icon-bundle/register';

import App from './views/App.vue';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import ui from '@nuxt/ui/vue-plugin';
import { router } from './router';

const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);

const app = createApp(App);

app.use(router);
app.use(pinia);
app.use(ui);

app.mount('#app');

function hideSplash() {
    const splash = document.getElementById('app-splash');
    if (!splash) return;

    splash.classList.add('is-hidden');

    window.setTimeout(() => splash.remove(), 400);
}

requestAnimationFrame(() => requestAnimationFrame(hideSplash));