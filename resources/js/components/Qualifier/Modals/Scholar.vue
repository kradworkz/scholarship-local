<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Scholar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <blockquote class="p-3 border-light border rounded">
                    <div class="d-flex">
                        <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                        <div>
                            <p class="mb-1 font-weight-bold" v-bind:class="[(user.gender == 0? 'text-danger' : 'text-primary')]">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }} <span class="text-muted font-size-11 ml-2">({{user.category_id.name}})</span> </p>
                        </div>
                    </div>
                    <div class="row font-size-11 mt-2">
                        <div class="col-sm-12">
                            <p class="font-weight-bold text-danger mb-0">{{user.barangay}}, {{user.municipality}}, {{user.province}}</p>
                            <p class="font-weight-bold text-dark mb-0">{{user.school}}</p>
                            <p class="text-dark mb-0">{{user.course}}</p>
                        </div>
                    </div>
                </blockquote>

                <form @submit.prevent="submit">
                    <div class="row customerform" style="margin-right: 5px; margin-left: 5px;">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Awarded Year: <span v-if="errors.awarded_year" class="haveerror">({{ errors.awarded_year[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="awarded_year">
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top: -12px;">
                                    <label>School: <span v-if="errors.school_id" class="haveerror">({{ errors.school_id[0] }})</span></label>
                                    <multiselect v-model="school" id="ajax" label="name" track-by="id"
                                        placeholder="Search School" open-direction="bottom" :options="schools"
                                        :searchable="true" 
                                        :allow-empty="false"
                                        :show-labels="false"
                                        @search-change="asyncSchool">
                                    </multiselect> 
                                </div>
                                <div class="col-md-12">
                                    <label>Course: <span v-if="errors.course_id" class="haveerror">({{ errors.course_id[0] }})</span></label>
                                    <multiselect v-model="course" id="ajax" label="name" track-by="id"
                                        placeholder="Search Course" open-direction="bottom" :options="courses"
                                        :searchable="true" 
                                        :allow-empty="false"
                                        :show-labels="false"
                                        @search-change="asyncCourse">
                                    </multiselect> 
                                </div>
                            </div>   
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Region: <span v-if="errors.region" class="haveerror">({{( errors.region[0] )}})</span></label>
                                            <multiselect 
                                            @input="onChangeRegion(region.code)"
                                            v-model="region" 
                                            :options="regions"
                                            :allow-empty="false"
                                            :show-labels="false"
                                            label="region" track-by="code"
                                            placeholder="Select Region">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-md-12"  style="margin-top: -15px;">
                                    <div class="form-group">
                                        <label>Province: <span v-if="errors.province" class="haveerror">({{( errors.province[0] )}})</span></label>
                                            <multiselect 
                                            @input="onChangeProvince(province.code)"
                                            v-model="province" 
                                            :options="provinces"
                                            :allow-empty="false"
                                            :show-labels="false"
                                            label="name" track-by="code"
                                            placeholder="Select Province">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-md-12"  style="margin-top: -15px;">
                                    <div class="form-group">
                                        <label>Municipality: <span v-if="errors.municipality" class="haveerror">({{( errors.municipality[0] )}})</span></label>
                                            <multiselect 
                                            v-model="municipality" 
                                            :options="municipalities"
                                            :allow-empty="false"
                                            :show-labels="false"
                                            label="name" track-by="code"
                                            placeholder="Select Municipality">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>   
                        </div>
                        <div class="col-md-12 mt-4">
                            <button type="submit" class="btn btn-info btn-sm btn-block waves-effect waves-light mb-4">COMFIRM SCHOLAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                user: {
                    category_id: {}
                },
                profile_id : '',
                lrn: '',
                category_id: '',
                awarded_year: '',
                schools: [],
                courses: [],
                school: '',
                course: '',
                regions: [],
                provinces: [],
                municipalities: [],
                region: '',
                province: '',
                municipality: ''
            }
        },

        created(){
            this.fetchRegion();
        },

        methods : {
            set(data){
                this.user = data;
            },

            submit(){
                axios.post(this.currentUrl + '/request/scholar/store', {
                    qualifier_id: this.user.id,
                    applicant_id: this.user.applicant_id,
                    profile_id: this.user.profile_id,
                    lrn: this.user.lrn,
                    category_id: this.user.category_id.id,
                    status_id : 30,
                    school_id: this.school.id,
                    course_id: this.course.id,
                    awarded_year: this.awarded_year,
                    address : this.user.barangay,
                    region_id: this.region.id,
                    province_id: this.province.id,
                    municipality_id: this.municipality.id
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                         this.isLoading = false;
                    }
                });
            },

            asyncSchool(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/schools', {
                        word: value,
                    })
                    .then(response => {
                        this.schools = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            asyncCourse(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/lists/courses', {
                        word: value,
                    })
                    .then(response => {
                        this.courses = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },

            fetchRegion(){
                axios.get(this.currentUrl + '/lists/regions')
                .then(response => {
                    this.regions = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchProvince($id){
                axios.get(this.currentUrl + '/lists/provinces/'+$id)
                .then(response => {
                    this.provinces = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchMunicipality($id){
                axios.get(this.currentUrl + '/lists/municipalities/'+$id)
                .then(response => {
                    this.municipalities = response.data.data;
                })
                .catch(err => console.log(err));
            },

            onChangeRegion($id) {
                this.fetchProvince($id);
                this.province = '';
                this.municipality = '';
            },

            onChangeProvince($id) {
                this.fetchMunicipality($id);
                this.municipality = '';
            },

            clear(){
                this.awarded_year = '';
                this.region = '';
                this.province = '';
                this.municipality = '';
                this.school = '';
                this.course = '';
                $("#scholar").modal('hide');
            }
            
        }, components : { Multiselect }
    }
</script>


