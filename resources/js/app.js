/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueRouter from 'vue-router';
import routes from './routes';
import AppComponent from './components/AppComponent.vue';


Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history',
    routes
})
require('./bootstrap');
Vue.component('app-component', {
    template: AppComponent
})

const app = new Vue({
    el: '#app',
    router,
    components: { AppComponent }
});
