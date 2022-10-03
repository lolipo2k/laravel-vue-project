import Vue from 'vue';
import Vuex from 'vuex';
import projects from './projects';
import user from './user';
import taxonomy from './taxonomy';

Vue.use(Vuex);

export default new Vuex.Store({
    // https://vuex.vuejs.org/guide/strict.html
    // strict: process.env.NODE_ENV !== 'production',
    modules: {
        projects,
        user,
        taxonomy
    }
});
