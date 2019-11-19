
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import * as VueGoogleMaps from "vue2-google-maps"
window.moment = require('moment');

window.Vue = require('vue');

Vue.use(VueGoogleMaps, {
    load: {
        key: ""
    }
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('gmap-component', require('./components/GMapComponent.vue'));
Vue.component('upload-component', require('./components/UploadComponent.vue'));
Vue.component('update-component', require('./components/UpdateComponent.vue'));
Vue.component('dealer-filter', require('./components/DealerFilterComponent.vue'));
const app = new Vue({
    el: '#app'
});
