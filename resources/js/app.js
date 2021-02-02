require('./bootstrap');
window.Vue = require('vue');

Vue.component('dashboard-manager', require('./components/DashboardManager.vue').default);
Vue.mixin({
    methods: {
        persianDate: enDateString => new Date(enDateString).toLocaleDateString('fa-IR'), // convert date to persian
        weekDay: enDateString => new Date(enDateString).toLocaleString('fa-IR', {weekday:'long'}), // convert date to persian week day
        getTime: dateString => new Date(dateString).toLocaleTimeString(), // extract time in date string
        boolIcon : value => value ? '<i class="icon-check text-success">' : '<i class="icon-cancel text-danger">', // return check icon or close icon based on a boolean value
        dclone: obj => JSON.parse(JSON.stringify(obj)), // deep clone an object
        redirect : path => location.href = path, // redirect to a path
        shorter : str => str ? (str.length > 33 ? (str.substring(0, 33) + '...') : str) : '-'
    }
})

const app = new Vue({
    el: '#vue-app',
});
