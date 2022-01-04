<template>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Scholar Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                   <div class="twitter-bs-wizard" style="margin-right: 10px; margin-left: 10px;">
                        <ul class="twitter-bs-wizard-nav nav nav-pills nav-justified">
                            <li class="nav-item">
                                <a href="#profile" class="nav-link active" data-toggle="tab">
                                    <span class="step-number mr-2"><i class='bx bxs-user'></i></span>
                                    Profile
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#address" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2"><i class='bx bxs-map'></i></span>
                                    Address
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#information" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2"><i class='bx bxs-detail'></i></span>
                                   Information
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#confirm" class="nav-link" data-toggle="tab">
                                    <span class="step-number mr-2">04</span>
                                    Confirm 
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content twitter-bs-wizard-tab-content">
                            <div class="tab-pane active" id="profile">

                                <div class="row customerform">
                                    <div class="col-md-3" style="margin-top: 10px; margin-bottom: 15px;">
                                        <myUpload field="img" @crop-success="cropSuccess" v-model="photo.show" :width="500" :height="500" :params="params" :headers="headers" lang-type="en" img-format="png">
                                        </myUpload>
                                        <div @click="toggleShow" class="fuzone" style="width: 225px; height: 210px;">
                                            <div v-if="photo.url != ''">
                                                <img :src="photo.url" style="width: 200px; height: 200x;">
                                            </div>
                                            <div v-else class="fu-text" @click="toggleShow">
                                                <span><i class="fa fa-picture"></i> Click here to upload<br> <span
                                                        v-if="errors.avatar"
                                                        style="color: red; font-size: 12px; margin-top: -20px;">
                                                        ({{ errors.avatar[0] }})</span></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 customerform" style="margin-top: 20px; margin-bottom: 15px;">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Lastname: <span v-if="errors.lastname" class="haveerror">({{ errors.lastname[0] }})</span></label>
                                                    <input type="text" class="form-control" v-model="user.lastname" style="text-transform: capitalize;">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Firstname: <span v-if="errors.firstname" class="haveerror">({{ errors.firstname[0] }})</span></label>
                                                    <input type="text" class="form-control" v-model="user.firstname" style="text-transform: capitalize;">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Middlename: <span v-if="errors.middlename" class="haveerror">({{ errors.middlename[0] }})</span></label>
                                                    <input type="text" class="form-control" v-model="user.middlename" style="text-transform: capitalize;">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Ext: <span v-if="errors.suffix" class="haveerror">({{ errors.suffix[0] }})</span></label>
                                                    <input type="text" class="form-control" v-model="user.suffix" style="text-transform: capitalize;">
                                                </div>
                                            </div>
                                            <!--<div class="col-md-4" style="margin-top: -7px;">
                                                <div class="form-group">
                                                    <label>Email: <span v-if="errors.email" class="haveerror">({{ errors.email[0] }})</span></label>
                                                    <input type="email" class="form-control" v-model="user.email" style="text-transform: lowercase;">
                                                </div>
                                            </div>
                                            <div class="col-md-4" style="margin-top: -7px;">
                                                <div class="form-group">
                                                    <label>Mobile No.: <span v-if="errors.mobile" class="haveerror">({{ errors.mobile[0] }})</span></label>
                                                    <input type="text" class="form-control" v-model="user.mobile">
                                                </div>
                                            </div>-->

                                            <div class="col-md-4">
                                                <div class="row" style="margin-top: 10px; margin-bottom: -10px;">
                                                    <div class="col-md-4">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio1" class="custom-control-input" checked="checked" value="Male" v-model="user.gender">
                                                            <label class="custom-control-label" for="customRadio1">Male</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8">
                                                        <div class="custom-control custom-radio mb-3">
                                                            <input type="radio" id="customRadio2" class="custom-control-input" checked="checked" value="Female" v-model="user.gender">
                                                            <label class="custom-control-label" for="customRadio2">Female</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-12">
                                                <hr></hr>
                                            </div>

                                            <div class="col-md-6" style="margin-top: 0px;">
                                                <div class="form-group">
                                                    <label>Mother: <span v-if="errors.mother" class="haveerror">({{ errors.mother[0] }})</span></label>
                                                    <input type="text" class="form-control" v-model="user.mother" style="text-transform: lowercase;">
                                                </div>
                                            </div>
                                            <div class="col-md-6" style="margin-top: 0px;">
                                                <div class="form-group">
                                                    <label>Father: <span v-if="errors.father" class="haveerror">({{ errors.father[0] }})</span></label>
                                                    <input type="text" class="form-control" v-model="user.father">
                                                </div>
                                            </div>
                                                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="address">
                                <!--<div class="col-md-12 customerform" style="margin-top: 10px;">
                                    <div class="row">
                                      
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Region: <span v-if="errors.lastname" class="haveerror">({{ errors.lastname[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.lastname" style="text-transform: capitalize;">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Province: <span v-if="errors.lastname" class="haveerror">({{ errors.lastname[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.lastname" style="text-transform: capitalize;">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Municipality: <span v-if="errors.firstname" class="haveerror">({{ errors.firstname[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.firstname" style="text-transform: capitalize;">
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="margin-top: -7px;">
                                            <div class="form-group">
                                                <label>Barangay: <span v-if="errors.middlename" class="haveerror">({{ errors.middlename[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.middlename" style="text-transform: capitalize;">
                                            </div>
                                        </div>    

                                        <div class="col-md-4" style="margin-top: -7px;">
                                            <div class="form-group">
                                                <label> House No. / Street: <span v-if="errors.lastname" class="haveerror">({{ errors.lastname[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.lastname" style="text-transform: capitalize;">
                                            </div>
                                        </div>
                                        <div class="col-md-2"  style="margin-top: -7px;">
                                            <div class="form-group">
                                                <label>District: <span v-if="errors.firstname" class="haveerror">({{ errors.firstname[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.firstname" style="text-transform: capitalize;">
                                            </div>
                                        </div>
                                        <div class="col-md-2"  style="margin-top: -7px;">
                                            <div class="form-group">
                                                <label>Zip Code: <span v-if="errors.middlename" class="haveerror">({{ errors.middlename[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.middlename" style="text-transform: capitalize;">
                                            </div>
                                        </div>    

                                        <div class="col-md-12">
                                            <hr></hr>
                                        </div>

                                        <div class="col-md-4" style="margin-top: 0px;">
                                            <div class="form-group">
                                                <label>School: <span v-if="errors.mother" class="haveerror">({{ errors.mother[0] }})</span></label>
                                                <input type="email" class="form-control" v-model="user.mother" style="text-transform: lowercase;">
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="margin-top: 0px;">
                                            <div class="form-group">
                                                <label>Course: <span v-if="errors.father" class="haveerror">({{ errors.father[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.father">
                                            </div>
                                        </div> 
                                        <div class="col-md-4" style="margin-top: 0px;">
                                            <div class="form-group">
                                                <label>Level: <span v-if="errors.father" class="haveerror">({{ errors.father[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.father">
                                            </div>
                                        </div>  

                                    </div>
                                </div>-->
                            </div>
                            <div class="tab-pane" id="information">
                                <div class="col-md-12 customerform" style="margin-top: 10px; margin-bottom: 15px;">
                                    <div class="row">

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email Address: <span v-if="errors.email" class="haveerror">({{ errors.email[0] }})</span></label>
                                                <input type="email" class="form-control" v-model="user.email" style="text-transform: lowercase;">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Mobile No.: <span v-if="errors.mobile" class="haveerror">({{ errors.mobile[0] }})</span></label>
                                                <input type="number" class="form-control" v-model="user.mobile">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Social Media: <span v-if="errors.social" class="haveerror">({{ errors.social[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.social" placeholder="separate using ," style="text-transform: lowercase;">
                                            </div>
                                        </div>    

                                        <div class="col-md-12">
                                            <hr></hr>
                                        </div>  

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Learner's Reference No.: <span v-if="errors.lrn" class="haveerror">({{ errors.lrn[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.lrn" style="text-transform: uppercase;">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>SPAS ID No.: <span v-if="errors.spas" class="haveerror">({{ errors.spas[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.spas" style="text-transform: uppercase;">
                                            </div>
                                        </div> 

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Category: <span v-if="errors.category_id" class="haveerror">({{ errors.category_id[0] }})</span></label>
                                                <multiselect 
                                                    v-model="user.category_id" 
                                                    :options="categories"
                                                    :show-labels="false"
                                                    label="name" track-by="id" 
                                                    :allow-empty="false"
                                                    placeholder="Select Category">
                                                </multiselect>
                                            </div>
                                        </div>

                                         <div class="col-md-4" style="margin-top: -7px;">
                                            <div class="form-group">
                                                <label>Status: <span v-if="errors.status_id" class="haveerror">({{ errors.status_id[0] }})</span></label>
                                                <multiselect 
                                                    v-model="user.status_id" 
                                                    :options="options" group-values="libs" group-label="language"
                                                    :show-labels="false"
                                                    label="name" track-by="id" 
                                                    :allow-empty="false"
                                                    placeholder="Select Status">
                                                </multiselect>
                                            </div>
                                        </div>

                                        <div class="col-md-4" style="margin-top: -7px;">
                                            <div class="form-group">
                                                <label>Year Awarded: <span v-if="errors.awarded_year" class="haveerror">({{ errors.awarded_year[0] }})</span></label>
                                                <input type="text" class="form-control" v-model="user.awarded_year">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="tab-pane" id="confirm">
                               <div class="row justify-content-center">
                                    <div class="col-lg-6">
                                        <div class="text-center">
                                            <div class="mb-4">
                                                <i class="mdi mdi-check-circle-outline text-success display-4"></i>
                                            </div>
                                            <div>
                                                <h5>Confirm Detail</h5>
                                                <p class="text-muted">If several languages coalesce, the grammar of the resulting</p>
                                                <button type="submit" class="btn btn-primary"><span>Create</span></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!--<ul class="pager wizard twitter-bs-wizard-pager-link">
                            <li class="previous"><a href="javascript: void(0);">Previous</a></li>
                            <li class="next"><a href="javascript: void(0);">Next</a></li>
                        </ul>-->
                    </div>

                </div>
            </form>

              <loading :active.sync="isLoading" :can-cancel="true" loader="dots" background-color="black" :is-full-page="fullPage"></loading>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-overlay';
    import Multiselect from 'vue-multiselect';
    import myUpload from 'vue-image-crop-upload/upload-2.vue';
    export default {
        props : ['statuses','categories'],
        data(){
            return {
                currentUrl: window.location.origin,
                windowHeight: window.innerHeight,
                windowWidth: window.innerWidth,
                errors: [], 
                user: {
                    id: '',
                    email: '',
                    firstname: '',
                    lastname: '',
                    middlename: '',
                    suffix: '',
                    gender: '', 
                    mobile: '',
                    avatar: '',
                    father: '',
                    mother: '',
                    lrn: '',
                    spas: '',
                    category_id: '',
                    status_id: '',
                    awarded_year: '',
                    social: ''
                },
                attachments: [],
                photo: {show: false,url: '',signature: ''},
                params: {token: '123456798',name: 'avatar'},
                headers: {smail: '*_~'},
                editable: false,
                options: [
                    {
                        language: 'Ongoing',
                        libs: []
                    },
                    {
                        language: '',
                        libs: []
                    }
                ],
                isLoading: false,
                fullPage: true
            }
        },
        
        created(){
            this.options[0].libs = this.statuses.filter(x => x.type === 'ongoing');
            this.options[1].libs = this.statuses.filter(x => x.type != 'ongoing');
        },

        computed : {
            height: function() {
                return this.windowHeight - 120;
            },
            width: function() {
                return this.windowWidth;
            },
        },
        
        methods : {
            create(){
                this.isLoading = true;
                let data = new FormData();

                if(this.attachments.length > 0){
                    for (var i = this.attachments.length - 1; i >= 0; i--) {
                        data.append('files[]', this.attachments[i]);
                    }
                }else{
                    if(this.editable == false){
                        data.append('files[]', []);
                    }
                }

                data.append('id', (this.user.id != undefined) ? this.user.id : '');
                data.append('email', (this.user.email != undefined) ? this.user.email : '');
                data.append('firstname', (this.user.firstname != undefined) ? this.user.firstname : '');
                data.append('lastname', (this.user.lastname != undefined) ? this.user.lastname : '');
                data.append('middlename', (this.user.middlename != undefined) ? this.user.middlename : '');
                data.append('suffix', (this.user.suffix != undefined) ? this.user.suffix : '');
                data.append('gender', (this.user.gender != undefined) ? this.user.gender : '');
                data.append('mobile', (this.user.mobile != undefined) ? this.user.mobile : '');
                data.append('social', (this.user.social != undefined) ? this.user.social : '');
                data.append('father', (this.user.father != undefined) ? this.user.father : '');
                data.append('mother', (this.user.mother != undefined) ? this.user.mother : '');
                data.append('img', (this.photo.url != undefined) ? this.photo.url : '');
                data.append('lrn', (this.user.lrn != undefined) ? (this.user.lrn == 'N/A') ? '' : this.user.lrn : '');
                data.append('spas', (this.user.spas != undefined) ? this.user.spas : '');
                data.append('awarded_year', (this.user.awarded_year != undefined) ? this.user.awarded_year : '');
                data.append('category_id', (this.user.category_id != undefined) ? this.user.category_id.id : '');
                data.append('status_id', (this.user.status_id != undefined) ? this.user.status_id.id : '');
                data.append('editable', this.editable);

                axios.post(this.currentUrl + '/request/scholar/store', data)
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.clear();
                    this.isLoading = false;
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.isLoading = false;
                    }
                });
            },

            edit(user,editable){
                this.errors = [];
                this.user = user;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                $("#new").modal("hide");
                this.errors = [];
                this.user = {};
            },

            toggleShow() {
                this.photo.show = !this.photo.show;
            },

            cropSuccess(imgDataUrl, field) {
                this.photo.url = imgDataUrl;
            }

        }, components: { Multiselect, myUpload, Loading }
    }
</script>