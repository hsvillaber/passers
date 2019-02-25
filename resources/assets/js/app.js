require('./bootstrap');

window.Vue = require('vue');

Vue.component('projects', require('./components/Projects.vue'));

Vue.component('schools', require('./components/Schools.vue'));

const app = new Vue({
    el: '#app',
});
