<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>

    import VueRouter from 'vue-router';
    import ScheduleMain from './schedule/ScheduleMain.vue';
    import ComptMain from './compt/ComptMain.vue';

    export default {
        router : new VueRouter ({
            routes : [
                {
                    path : '/',
                    redirect : {name : 'schedule'}
                },
                {
                    path : '/schedule',
                    name : 'schedule',
                    component : ScheduleMain
                },
                {
                    path : '/compt',
                    name : 'compt',
                    component : ComptMain
                },
            ]
        })
    }
</script>
