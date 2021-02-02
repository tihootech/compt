<template>
    <div class="panel">
        <div class="panel-body">
            <div class="top-of-page">
                <h3> لیست فوق برنامه های تعریف شده </h3>
                <a href="#/schedule/main" class="btn btn-info btn-sm">
                    <i class="icon-right-thin"></i>
                    بازگشت به صفحه قبل
                </a>
            </div>
            <hr>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th> # </th>
                        <th> محل برگزاری </th>
                        <th> نام مربی </th>
                        <th> رشته </th>
                        <th> جنسیت </th>
                        <th> ظرفیت </th>
                        <th> تعداد جلسات </th>
                        <th> شروع اتوماتیک </th>
                        <th> وضعیت </th>
                        <th colspan="2"> عملیات </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="c, i in courses">
                        <th> {{i+1}} </th>
                        <td> {{c.place_name}} </td>
                        <td> {{c.coach_name}} </td>
                        <td> {{c.field_name}} </td>
                        <td> {{c.male ? 'آقایان' : 'بانوان'}} </td>
                        <td> {{c.capacity}} </td>
                        <td> {{c.sessions}} </td>
                        <td v-html="boolIcon(c.auto_start)"></td>
                        <td> {{c.persian_status}} </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-success" data-toggle="tooltip" title="ویرایش">
                                <i class="icon-pencil"></i>
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="tooltip" title="حذف">
                                <i class="icon-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data : function () {
        return {
            courses : []
        }
    },
    mounted : function () {
        axios.get('/api/courses').then(res => {
            this.courses = res.data;
        });
    }
}
</script>

<style scoped>

    

</style>
