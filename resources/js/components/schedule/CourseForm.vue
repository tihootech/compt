<template>
    <div class="panel">
        <div class="panel-body">
            <div class="top-of-page">
                <h3> پیش تعریف فوق برنامه </h3>
                <a href="#/schedule/main" class="btn btn-info btn-sm">
                    <i class="icon-right-thin"></i>
                    بازگشت به صفحه قبل
                </a>
            </div>
            <hr>
            <form @submit.prevent="submitCourseForm">

                <div class="row">
                    <div class="form-group col-md-3">
                        <label> انتخاب سالن </label>
                        <select class="form-control" v-model="course.salon">
                            <option v-for="s, i in salons" :value="s.id">{{s.name}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label> محل برگزاری </label>
                        <select class="form-control" v-model="course.place">
                            <option v-if="p.salon_id == course.salon" v-for="p, i in places" :value="p.id">{{p.name}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label> انتخاب مربی </label>
                        <select class="form-control" v-model="course.coach">
                            <option v-for="c, i in coachs" :value="c.id">{{c.name}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label> انتخاب رشته </label>
                        <select class="form-control" v-model="course.field">
                            <option v-for="f, i in fields" :value="f.id">{{f.name}}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-2 col-md-offset-3">
                        <label> ظرفیت </label>
                        <input type="number" v-model="course.capacity" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                        <label> تعداد جلسات </label>
                        <input type="number" v-model="course.sessions" class="form-control">
                    </div>
                    <div class="form-group col-md-2">
                        <label> جنسیت </label>
                        <select class="form-control" v-model="course.male">
                            <option value="1">آقایان</option>
                            <option value="0">بانوان</option>
                        </select>
                    </div>
                </div>

                <hr>

                <div>
                    <div class="checkboxes">
                        <label v-for="day, index in days"> <input type="checkbox" @change="selectDay(index)"> {{day}} </label>
                    </div>
                    <hr v-if="selectedDays.length">
                    <div class="row">
                        <div class="col-md-6" v-for="day, index in days" v-if="selectedDays.includes(index)">
                            <p class="bg-info schedule-day-title"> {{day}} </p>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label> از ساعت </label>
                                    <date-picker type="time" required v-model="schedules[index].from"/>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label> تا ساعت </label>
                                    <date-picker type="time" required v-model="schedules[index].till"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <label> <input type="checkbox" v-model="course.auto_start"> درصورت تکمیل ظرفیت این دوره به صورت اتوماتیک آغاز شود </label>

                <div class="row">
                    <div class="col-md-2 col-md-offset-5 form-group">
                        <button type="submit" class="btn btn-block btn-primary"> تایید </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</template>

<script>

import VuePersianDatetimePicker from 'vue-persian-datetime-picker';

export default {
    data : function() {
        return {
            course : {},
            fields : [],
            places : [],
            coachs : [],
            schedules : [
                {from:null, till:null},
                {from:null, till:null},
                {from:null, till:null},
                {from:null, till:null},
                {from:null, till:null},
                {from:null, till:null},
                {from:null, till:null},
            ],
            selectedDays : [],
            days : [
                'شنبه', 'یکشنبه', 'دوشنبه', 'سه شنبه', 'چهارشنبه', 'پنجشنبه', 'جمعه'
            ]
        }
    },
    components : {
        'date-picker' : VuePersianDatetimePicker,
    },
    mounted : function () {
        axios.get('/api/baseinfo').then(res => {
            this.salons = res.data.salons;
            this.places = res.data.places;
            this.fields = res.data.fields;
            this.coachs = res.data.coachs;
        });
    },
    methods : {
        selectDay : function (dayNumber) {
            var index = this.selectedDays.indexOf(dayNumber);
            if (index !== -1) {
                this.selectedDays.splice(index, 1);
            }else {
                this.selectedDays.push(dayNumber);
            }
        },
        submitCourseForm : function () {
            axios.post(`/api/course/upsert`, {course : this.course, schedules : this.schedules}).catch(error => {
                if (error.response.status == 422) {
                    swalValidationErrors(error.response.data.errors);
                }
            }).then(res => {
                if (res.data.success) {
                    swalSuccess();
                    this.redirect('#/schedule/main');
                }else if(res.data.errors) {
                    swalErrors(res.data.errors);
                }
            });
        }
    }
}
</script>

<style scoped>

    .checkboxes {
        text-align: center;
    }

    .checkboxes > label {
        margin: 0 4px;
    }

    .float-left {
        float: left;
    }

    .pointer {
        cursor: pointer;
    }

    .schedule-day-title {
        margin: 5px;
        padding: 10px;
        text-align: center;
    }

</style>
