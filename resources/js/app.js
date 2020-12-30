require('./bootstrap');
window.Vue = require('vue');
Vue.component('dashboard-manager', require('./components/DashboardManager.vue').default);
Vue.mixin({
  methods: {
    persianDate: enDateString => new Date(enDateString).toLocaleDateString('fa-IR'), // convert date to persian
    getTime: dateString => new Date(dateString).toLocaleTimeString(), // extract time in date string
    boolIcon : value => value ? '<i class="mdi mdi-check text-success">' : '<i class="mdi mdi-close text-danger">' // return check icon or close icon based on a boolean value
  }
})
const app = new Vue({
    el: '#vue-app',
});
