import Vue from 'vue';
require('./bootstrap');
import DashboardComponent from './components/DashboardComponent.vue';

Vue.component('dashboard', DashboardComponent);

const app = new Vue({
    el: '#app'
});
