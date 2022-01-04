<template>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Staff Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                    
                    <div class="row customerform" style="margin-right: 10px; margin-left: 10px;">
                        
                        <div class="col-md-3" style="margin-top: 20px;">
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
                        <div class="col-md-9 customerform" style="margin-top: 20px;">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Lastname: <span v-if="errors.lastname" class="haveerror">({{ errors.lastname[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="user.lastname" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Firstname: <span v-if="errors.firstname" class="haveerror">({{ errors.firstname[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="user.firstname" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Initial: <span v-if="errors.middlename" class="haveerror">({{ errors.middlename[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="user.middlename" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-4" style="margin-top: -7px;">
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
                                </div>
                                <div class="col-md-4" style="margin-top: -7px;">
                                    <div class="form-group">
                                        <label>Role: <span v-if="errors.role" class="haveerror">({{ errors.role[0] }})</span></label>
                                          <multiselect 
                                            v-model="user.role" 
                                            :options="roles"
                                            :allow-empty="false"
                                            :show-labels="false"
                                            placeholder="Select Role">
                                        </multiselect>
                                    </div>
                                </div>

                                <div class="col-md-6" style="margin-top: -10px;">
                                    <div class="row" style="margin-top: 20px;">
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
                                                            
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><span v-if="editable == true">Update</span><span v-else>Create</span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
            <loading :active.sync="isLoading" :can-cancel="false" loader="dots" background-color="black" :is-full-page="fullPage"></loading>

        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-overlay';
    import Multiselect from 'vue-multiselect';
    import myUpload from 'vue-image-crop-upload/upload-2.vue';
    export default {
        props : ['type'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                user: {
                    id: '',
                    email: '',
                    firstname: '',
                    lastname: '',
                    middlename: '',
                    role: '',
                    gender: '', 
                    mobile: '',
                    avatar: '', 
                },
                roles: ['Super Administrator','Scholarship Coordinator','Scholarship Staff'],
                photo: {show: false,url: '',signature: ''},
                params: {token: '123456798',name: 'avatar'},
                headers: {smail: '*_~'},
                editable: false,
                isLoading: false,
                fullPage: true
            }
        },
        
        methods : {
            create(){
                this.isLoading = true;
                axios.post(this.currentUrl + '/request/admin/user/store', {
                    id: this.user.id,
                    firstname: this.user.firstname,
                    lastname: this.user.lastname,
                    middlename: this.user.middlename,
                    email: this.user.email,
                    gender: this.user.gender,
                    mobile: this.user.mobile,
                    role: this.user.role,
                    img: this.photo.url,
                    editable: this.editable
                })
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
                this.user = user;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                $("#new").modal("hide");
                this.errors = [];
                this.users = {};
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