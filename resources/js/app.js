import Vue from "vue";
import App from "./App.vue";
import store from "./store";
import router from "./router";
import {BootstrapVue, BootstrapVueIcons} from 'bootstrap-vue'
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
import axios from 'axios';
import VueAxios from 'vue-axios';
import auth from '@websanova/vue-auth';
import authBearerResource from '@websanova/vue-auth/drivers/auth/bearer.js';
import httpAxiosResource from '@websanova/vue-auth/drivers/http/axios.1.x.js';
import routerVueRouter from '@websanova/vue-auth/dist/drivers/router/vue-router.2.x.esm.js';
import {AUTH_LOGIN, AUTH_LOGOUT, AUTH_REFRESH, AUTH_REGISTER, AUTH_USER} from "./back-routes";
import Multiselect from 'vue-multiselect';
import VoerroTagsInput from '@voerro/vue-tagsinput';
import VueCardCarousel from "vue-card-carousel";
import FileUpload from 'v-file-upload';



Vue.component('multiselect', Multiselect);
Vue.component('tags-input', VoerroTagsInput);


import moment from 'moment';


require('./bootstrap');

Vue.use(BootstrapVue);
Vue.use(VueAxios, axios);
Vue.use(BootstrapVueIcons);
Vue.use(require('vue-moment'));
Vue.use(VueCardCarousel);
Vue.use(FileUpload);

let $bus = new Vue({});

window.$bus = $bus;
window.Vue = Vue;

Vue.router = router;
store.$axios = Vue.axios;

Vue.use(auth, {
    auth: authBearerResource,
    http: httpAxiosResource,
    router: routerVueRouter,
    rolesKey: 'role',
    registerData: {
        url: AUTH_REGISTER
    },
    loginData: {
        url: AUTH_LOGIN
    },
    logoutData: {
        url: AUTH_LOGOUT
    },
    fetchData: {
        url: AUTH_USER
    },
    refreshData: {
        url: AUTH_REFRESH
    }
});

Object.defineProperty(Vue.prototype, "$bus", {
    get: function () {
        return this.$root.bus;
    }
});



new Vue({
    router,
    store,
    data: {
        bus: $bus
    },
    render: h => h(App),
    computed: {
        _user() {
            return this.$auth.user() || {};
        }
    },
    watch: {
        _user() {
            this.$store.dispatch('user/set', this._user);
        }
    }
}).$mount('#app');







