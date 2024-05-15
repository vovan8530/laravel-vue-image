/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import {createApp} from 'vue';

import App from "./components/App.vue";
import router from "./router.js"


const app = createApp({})
    .component('App', App)
    .use(router)
    .mount('#app');


export default app
