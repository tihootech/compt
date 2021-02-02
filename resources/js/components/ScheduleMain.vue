<template>
    <div class="panel">
        <div class="panel-body">

            <div class="text-center">
                <a href="#/baseinfo/manage" class="btn btn-info btn-sm">
                    <i class="icon-doc-text-inv"></i>
                    مدیریت اطلاعات پایه
                </a>
                <a href="#/course/list" class="btn btn-info btn-sm">
                    <i class="icon-list"></i>
                    لیست برنامه های تعریف شده
                </a>
                <a href="#/course/form" class="btn btn-info btn-sm">
                    <i class="icon-plus"></i>
                    برنامه جدید
                </a>
            </div>

            <div v-if="openCourses.length" class="open-courses">
                <hr>
                <h3> <i class="icon-login"></i> دوره های درحال ثبت نام </h3>
                <div class="row">
                    <div v-for="course, index in openCourses" class="col-md-6 p-10">
                        <div class="bg-info text-center p-10">
                            <b> {{course.name}} </b>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <span> ظرفیت دوره : {{course.capacity}} </span>
                                </div>
                                <div class="col-md-4">
                                    <span> تعداد جلسات : {{course.sessions}} </span>
                                </div>
                                <div class="col-md-4">
                                    <span> ثبت نامی : 0 </span>
                                </div>
                            </div>
                            <hr>
                            <p v-if="course.auto_start" class="text-success"> این دوره درصورت تکمیل ظرفیت اتوماتیک شروع خواهد شد </p>
                            <p v-else class="text-danger"> این دوره شروع اتوماتیک نخواهد داشت </p>
                            <button type="button" class="btn btn-primary" @click="initCourse(course, index)"> شروع دوره </button>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <div class="schedule">
                <div v-for="sessions,date in days" class="day">
                    <span class="day-title">
                        {{weekDay(date)}}
                        <br>
                        {{persianDate(date)}}
                    </span>
                    <span class="day-session" v-for="s,i in sessions">
                        {{s.course.name}}
                        <br>
                        از {{s.from.slice(0, -3)}} تا {{s.till.slice(0, -3)}}
                        <hr class="less-margin">
                        <button type="button" class="btn btn-light btn-sm text-dark"> مدیریت </button>
                    </span>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            openCourses : [],
            days : []
        }
    },
    mounted : function () {
        axios.get('/api/courses/open').then(res => {
            this.openCourses = res.data;
        });
        axios.get('/api/calendar/sessions').then(res => {
            this.days = res.data;
        });
    },
    methods : {
        initCourse : function (course, index) {
            axios.post(`/api/course/init/${course.id}`).then(res => {
                if (res.data.success) {
                    this.openCourses.splice(index, 1);
                    this.days = res.data.days;
                    swalSuccess('دوره مورد نظر شروع شد.')
                }else {
                    swalError();
                }
            });
        }
    }
}
</script>


<style scoped>

    .text-dark {
        color: #000;
    }

    .p-10 {
        padding: 10px;
    }

    .less-margin {
        margin: 5px 0;
    }

    .schedule > .day {
        display: flex;
        text-align: center;
        border: 1px solid gray;
        margin: 5px 0;
        color: #fff;
        line-height: 2em;
    }

    .schedule > .day > .day-title {
        width: 10%;
        background-color: #aa0efb;
    }

    .schedule > .day > .day-session:nth-child(even) {
        background-color: #1cc26f;
    }
    .schedule > .day > .day-session:nth-child(odd) {
        background-color: #eb233a;
    }

    .schedule > .day > span {
        padding: 10px;
    }

</style>
