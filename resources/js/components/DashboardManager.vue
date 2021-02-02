<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>

    import VueRouter from 'vue-router';
    import ScheduleMain from './ScheduleMain.vue';
    import ManageBaseInfo from './base/ManageBaseInfo.vue';
    import CourseForm from './schedule/CourseForm.vue';
    import CourseList from './schedule/CourseList.vue';

    export default {
        router : new VueRouter ({
            routes : [
                {
                    path : '/',
                    redirect : {name : 'schedule-main'}
                },
                {
                    path : '/schedule/main',
                    name : 'schedule-main',
                    component : ScheduleMain
                },
                {
                    path : '/course/form/:cid?',
                    name : 'form-course',
                    component : CourseForm
                },
                {
                    path : '/course/list',
                    name : 'list-course',
                    component : CourseList
                },
                {
                    path : '/baseinfo/manage',
                    name : 'manage-baseinfo',
                    component : ManageBaseInfo
                },
            ]
        })
    }
</script>
