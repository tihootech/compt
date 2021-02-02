<template>
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel">
                    <div class="panel-body">
                        <div class="top-of-page">
                            <h3> مدیریت اطلاعات پایه </h3>
                            <a href="#/schedule/main" class="btn btn-info btn-sm">
                                <i class="icon-right-thin"></i>
                                بازگشت به صفحه قبل
                            </a>
                        </div>
                        <hr>
                        <div class="text-center">
                            <button type="button" class="btn btn-info btn-sm" @click="openFormModal('salon', 'new')"> + تعریف سالن جدید </button>
                            <button type="button" class="btn btn-info btn-sm" @click="openFormModal('field', 'new')"> + تعریف رشته جدید </button>
                            <button type="button" class="btn btn-info btn-sm" @click="openFormModal('coach', 'new')"> + تعریف مربی جدید </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body">
                        <h4> مدیریت رشته ها </h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> نام </th>
                                    <th colspan="2"> عملیات </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="f, i in fields">
                                    <td> {{i+1}} </td>
                                    <td> {{f.name}} </td>
                                    <td title="ویرایش">
                                        <button type="button" class="btn btn-sm btn-success" @click="openFormModal('field', 'edit', f)">
                                            <i class="icon-pencil"></i>
                                        </button>
                                    </td>
                                    <td title="حذف">
                                        <button type="button" class="btn btn-sm btn-danger" @click="delInfo('field', i)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="panel">
                    <div class="panel-body">
                        <h4> مدیریت سالن ها </h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> نام </th>
                                    <th> آدرس </th>
                                    <th colspan="3"> عملیات </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="s, i in salons">
                                    <td> {{i+1}} </td>
                                    <td> {{s.name}} </td>
                                    <td> {{shorter(s.address)}} </td>
                                    <td title="ویرایش">
                                        <button type="button" class="btn btn-sm btn-info" @click="openPlacesModal(s)">
                                            مدیریت محل های سالن
                                        </button>
                                    </td>
                                    <td title="ویرایش">
                                        <button type="button" class="btn btn-sm btn-success" @click="openFormModal('salon', 'edit', s)">
                                            <i class="icon-pencil"></i>
                                        </button>
                                    </td>
                                    <td title="حذف">
                                        <button type="button" class="btn btn-sm btn-danger" @click="delInfo('salon', i)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-body">
                        <h4> مدیریت مربی ها </h4>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> نام </th>
                                    <th> رشته فعالیت </th>
                                    <th> درجه مربیگری </th>
                                    <th> سابقه فعالیت </th>
                                    <th colspan="2"> عملیات </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="c, i in coachs">
                                    <td> {{i+1}} </td>
                                    <td> {{c.name}} </td>
                                    <td> {{c.field_name}} </td>
                                    <td> {{c.degree}} </td>
                                    <td> {{shorter(c.exp)}} </td>
                                    <td title="ویرایش">
                                        <button type="button" class="btn btn-sm btn-success" @click="openFormModal('coach', 'edit', c)">
                                            <i class="icon-pencil"></i>
                                        </button>
                                    </td>
                                    <td title="حذف">
                                        <button type="button" class="btn btn-sm btn-danger" @click="delInfo('coach', i)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="places-modal" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">
                            {{currentSalon.name}}
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <button type="button" class="btn btn-info btn-sm" @click="addPlace"> + تعریف محل جدید برای این سالن </button>
                        </div>
                        <hr>
                        <div v-if="currentSalon.places.length > 0" v-for="p, i in currentSalon.places" class="row">
                            <div class="col-md-10 form-group">
                                <input type="text" class="form-control" v-model="p.name" required placeholder="نام محل">
                            </div>
                            <div class="col-md-2 form-group">
                                <button type="button" class="btn btn-sm btn-danger" @click="removePlace(i)">
                                    <i class="icon-trash"></i>
                                </button>
                            </div>
                        </div>
                        <div v-if="!currentSalon.places.length" class="alert alert-warning">
                            برای این سالن هنوز هیچ محلی تعریف نشده
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="icon-cancel"></i> بستن </button>
                        <button type="button" class="btn btn-primary" @click="managePlaces"> <i class="icon-check"></i> تایید </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="form-modal" tabindex="-1">
            <div class="modal-dialog" role="document">
                <form @submit.prevent="submitFormModal" class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">

                            <b v-if="activeModalAction == 'new'"> تعریف </b>
                            <b v-if="activeModalAction == 'edit'"> ویرایش </b>

                            <span v-if="activeModalType == 'salon'"> سالن </span>
                            <span v-if="activeModalType == 'place'"> محل </span>
                            <span v-if="activeModalType == 'field'"> رشته </span>
                            <span v-if="activeModalType == 'coach'"> مربی </span>

                        </h4>
                    </div>
                    <div class="modal-body">
                        <div v-if="activeModalType == 'salon'">
                            <div class="form-group">
                                <label> نام سالن </label>
                                <input type="text" class="form-control" v-model="activeObject.name">
                            </div>
                            <div class="form-group">
                                <label> آدرس </label>
                                <textarea class="form-control" v-model="activeObject.address" rows="3"></textarea>
                            </div>
                        </div>
                        <div v-if="activeModalType == 'place'">
                            <div class="form-group">
                                <label> نام محل </label>
                                <input type="text" class="form-control" v-model="activeObject.name">
                            </div>
                        </div>
                        <div v-if="activeModalType == 'field'">
                            <div class="form-group">
                                <label> نام رشته </label>
                                <input type="text" class="form-control" v-model="activeObject.name">
                            </div>
                        </div>
                        <div v-if="activeModalType == 'coach'">
                            <div class="form-group">
                                <label> نام مربی </label>
                                <input type="text" class="form-control" v-model="activeObject.name">
                            </div>
                            <div class="form-group">
                                <label> رشته فعالیت </label>
                                <select class="form-control" v-model="activeObject.field_id">
                                    <option v-for="f in fields" :value="f.id">{{f.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label> درجه مربیگری </label>
                                <input type="text" class="form-control" v-model="activeObject.degree">
                            </div>
                            <div class="form-group">
                                <label> سابقه فعالیت </label>
                                <textarea class="form-control" v-model="activeObject.exp" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="icon-cancel"></i> بستن </button>
                        <button type="submit" class="btn btn-primary"> <i class="icon-check"></i> تایید </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data : function () {
        return {
            activeModalType : '',
            activeModalAction : '',
            activeObject : {},
            currentSalon : { places : [] },
            salons : [],
            coachs : [],
            fields : [],
        }
    },
    mounted : function () {
        axios.get('/api/baseinfo').then(res => {
            this.salons = res.data.salons;
            this.coachs = res.data.coachs;
            this.fields = res.data.fields;
        });
    },
    methods : {
        openFormModal : function (type, action, object=null) {
            this.activeModalType = type;
            this.activeModalAction = action;
            if (action == 'new') {
                this.activeObject = {};
            }else {
                this.activeObject = object;
            }
            jQuery('#form-modal').modal('show');
        },
        openPlacesModal : function (salon) {
            this.currentSalon = salon;
            jQuery('#places-modal').modal('show');
        },
        submitFormModal : function () {
            var id = this.activeModalAction == 'edit' ? this.activeObject.id : 0;
            axios.post(`/api/baseinfo/${this.activeModalType}/${id}`, this.activeObject).catch( error => {
                if (error.response.status == 422) {
                    swalValidationErrors(error.response.data.errors);
                }
            }).then( res => {
                if (res.data.success) {
                    if (this.activeModalAction == 'new') {
                        this[res.data.type].push(res.data.object);
                    }
                    swalSuccess();
                }else {
                    swalError();
                }
            });
            jQuery('#form-modal').modal('hide');
        },
        managePlaces : function () {
            axios.post(`/api/baseinfo/salon/places/${this.currentSalon.id}`, this.currentSalon.places).then( res => {
                if (res.data.success) {
                    swalSuccess();
                    jQuery('#salon-modal').modal('hide');
                }else {
                    swalError();
                }
            });
            jQuery('#places-modal').modal('hide');
        },
        addPlace : function () {
            this.currentSalon.places.push({});
        },
        removePlace : function (index) {
            this.currentSalon.places.splice(index, 1);
        },
        delInfo : function (type, i) {
            var list = this[type+'s'];
            var id = list[i].id;
            axios.delete(`/api/baseinfo/${type}/${id}`).then(res => {
                if (res.data.success) {
                    list.splice(i, 1);
                    swalSuccess('آیتم مورد نظر حذف شد.');
                }
            });
        },
    }
}
</script>

<style lang="css" scoped>
</style>
