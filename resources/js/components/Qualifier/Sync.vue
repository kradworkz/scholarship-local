<template>
<div class="d-xl-flex">                
    <div class="w-100">
        <div class="card">
            <div class="card-body" :style="{ height: height + 'px' }">
                <div class="row">
                        <div class="col-md-12" v-if="view == false">
                            <div class="col-md-3 mx-auto mt-5"> 
                                <img class="img-fluid" src="/images/svg/sync.svg">
                                <div class="justify-content-center">
                                    <div class="col-xl-12">
                                        <p class="text-muted text-center font-size-12 mt-4">Check for available Qualifiers</p>
                                    </div>
                                </div>
                                <button type="button" @click="fetch" class="btn btn-success btn-sm btn-block waves-effect waves-light mt-2">Sync Qualifiers</button>
                            </div>
                        </div>

                                
                        <div class="table-responsive" v-else>
                            <div class="mb-3 float-right">
                                <ul>
                                    <li class="list-inline-item d-non d-sm-inline-block mr-4">     
                                        <i class='bx bxs-circle text-success'></i> <span class="text-muted font-size-11">Success <span v-if="success != ''">({{success}})</span></span>
                                    </li>
                                    <li class="list-inline-item d-non d-sm-inline-block mr-4">     
                                        <i class='bx bxs-circle text-danger'></i> <span class="text-muted font-size-11">Failed <span v-if="failed != ''">({{failed}})</span></span>
                                    </li>
                                    <li class="list-inline-item d-non d-sm-inline-block" style="margin-right: 100px;">     
                                        <i class='bx bxs-circle text-warning'></i> <span class="text-muted font-size-11">Duplicate <span v-if="duplicate != ''">({{duplicate}})</span></span>
                                    </li>
                                    <li class="list-inline-item d-non d-sm-inline-block">
                                        <button type="button" class="btn btn-light w-lg waves-effect waves-light ml-4">Validate</button>
                                    </li>
                                    <li class="list-inline-item d-non d-sm-inline-block">
                                        <button @click="sync" type="button" class="btn btn-success w-lg waves-effect waves-light">Sync ({{users.length}})</button>
                                    </li>
                                </ul>
                            </div>
                            <div  class="mb-3">
                                <form class="form-inline">
                                    <div class="search-box">
                                        <div class="position-relative">
                                            <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="search()">
                                        <i class='bx bx-search-alt search-icon'></i>
                                        </div>
                                    </div>
                                </form>
                            </div>
                       
                            <simplebar :style="{ height: (height - 105) + 'px' }">
                                <table class="table table-centered table-nowrap">
                                   
                                    <tbody>
                                        <tr v-for="user in users" v-bind:key="user.id" :id="user.details.applicant_id">
                                            <td>
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle">{{user.details.lname.charAt(0)}}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <h5 class="font-size-13 mb-0 text-dark">{{user.test}} {{user.details.lname}}, {{user.details.fname}} {{user.details.mname}}.</h5>
                                                <p class="font-size-11 text-muted mb-0">{{user.details.province}} {{user.details.municipality}}</p>
                                            </td>
                                            <td class="text-center">
                                                <h5 class="font-size-13 mb-0 text-dark">{{user.details.applied_program}}</h5>
                                                <p class="font-size-11 text-muted mb-0">LRN: {{user.details.deped_lrn}}</p>
                                            </td>
                                            <td class="text-center">
                                                <h5 class="font-size-11 mb-0 text-dark">{{user.details.school_name}}</h5>
                                                <p class="font-size-11 text-muted mb-0">{{user.details.course_name}}</p>
                                            </td>
                                            <td class="text-center">
                                                <h5 class="font-size-11 mb-0 text-dark">{{user.details.email}}</h5>
                                                <p class="font-size-11 text-muted mb-0">{{user.details.mobile_no}}</p>
                                            </td>
                                            <td class="text-right">
                                                <a class="mr-3 text-warning" @click="edit(user)"><i class='bx bx-edit-alt' ></i></a>
                                                <a class="text-danger"><i class='bx bx-trash'></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </simplebar>
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade exampleModal" id="sync" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <qualifier-sync-modal :users="users" @status="message" ref="sync"></qualifier-sync-modal>
    </div>
    <div class="modal fade exampleModal" id="confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <qualifier-confirm :users="users" @status="res" ref="sync"></qualifier-confirm>
    </div>
    <loading :active.sync="isLoading" :can-cancel="false" loader="dots" background-color="black" :is-full-page="fullPage"></loading>

</div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import simplebar from 'simplebar-vue';
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            windowHeight: window.innerHeight,
            windowWidth: window.innerWidth,
            keyword: '',
            errors: [],
            users : [],
            view: false,
            show: false,
            isLoading: false,
            fullPage: true,
            success: '',
            failed: '',
            duplicate: ''
        }
    },

    computed : {
        height: function() {
            return this.windowHeight - 170;
        }
    },

    methods: {
        search(){

        },
        
        fetch(){
            this.isLoading = true;
            axios.get(this.currentUrl+'/qualifiers')
            .then(response => {
                this.users = response.data;
                this.isLoading = false;
                $("#sync").modal("show");
            })
            .catch(err => console.log(err));
        },

        message(){
            $("#sync").modal("hide");
            this.view = true;
        },

        res(data){
            this.success = data.success.length;
            data.success.forEach((value, index) => {
                var ind = this.users.findIndex(x => x.details.applicant_id === value);
                $("#"+value).addClass("table-success");
            });
            this.failed = data.failed.length;
            data.failed.forEach((value, index) => {
                var ind = this.users.findIndex(x => x.details.applicant_id === value);
                $("#"+value).addClass("table-danger");
            });
            this.duplicate = data.duplicate.length;
            data.duplicate.forEach((value, index) => {
                var ind = this.users.findIndex(x => x.details.applicant_id === value);
                $("#"+value).addClass("table-warning");
            });
        },

        sync(){
            $("#confirm").modal("show");
        }
    }, components : { Loading, simplebar}
}
</script>