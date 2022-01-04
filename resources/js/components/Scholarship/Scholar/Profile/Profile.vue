<template>
    <div class="col-md-12">
        <blockquote class="p-3 border-light border rounded ">
            <a @click="edit(user)" class="float-right badge badge-warning font-size-10 ml-2"><i class='bx bxs-edit'>&nbsp;</i>Edit</a>
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-2 text-primary font-weight-bold">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }} </p>
                </div>
            </div>
            <div class="row font-size-12 mt-3">
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-mail-send mr-1 text-primary"></i>Email</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.email}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-phone mr-1 text-primary"></i>Mobile</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.mobile}}</p>
                </div>
                 <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-female mr-1 text-primary"></i>Mother</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.mother}}</p>
                </div>
                 <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-male mr-1 text-primary"></i>Father</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.father}}</p>
                </div>
            </div>
        </blockquote>

        <hr></hr>
        <div class="row">
            <div class="col-md-6">
                <blockquote class="p-3 border-light border rounded ">
                    <h6 class="card-title text-secondary mb-0 font-size-13">Education</h6>
                    <hr></hr>
                    <div class="row font-size-13 mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted"><i class="bx bxs-school mr-1 text-primary"></i>School</h6>
                            <p class="font-weight-bold text-dark mb-0">Ateneo de Zamboanga University</p>
                        </div>
                    </div>
                    <div class="row font-size-13 mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted"><i class="bx bxs-graduation mr-1 text-primary font-size-15"></i>Course</h6>
                            <p class="font-weight-bold text-dark mb-0">Bachelor of Science in Information Technology</p>
                        </div>
                    </div>
                    <div class="row font-size-13 mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted "><i class="bx bxs-calendar mr-1 text-primary"></i>Year level</h6>
                            <p class="font-weight-bold text-dark mb-0">First year</p>
                        </div>
                    </div>
                </blockquote>
            </div>
             <div class="col-md-6">
                <blockquote class="p-3 border-light border rounded ">
                    <h6 class="card-title text-secondary mb-0 font-size-13">Address</h6>
                    <hr></hr>
                    <div class="row font-size-13 mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted"><i class="bx bx-map mr-1 text-primary"></i>Region</h6>
                            <p class="font-weight-bold text-dark mb-0">Region 9</p>
                        </div>
                    </div>
                    <div class="row font-size-13 mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted"><i class="bx bx-map-alt mr-1 text-primary font-size-15"></i>Province</h6>
                            <p class="font-weight-bold text-dark mb-0">Zamboanga del Sur</p>
                        </div>
                    </div>
                    <div class="row font-size-13 mt-3">
                        <div class="col-sm-12">
                            <h6 class="text-muted "><i class="bx bx-sitemap mr-1 text-primary"></i>Municipality</h6>
                            <p class="font-weight-bold text-dark mb-0">Zamboanga City</p>
                        </div>
                    </div>
                </blockquote>
            </div>
        </div>

        <!--
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" style="width: 140px;">
                <a class="nav-link active" data-toggle="tab" href="#profile" role="tab" aria-selected="true">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-user-detail mr-1'></i> Profile
                    </span>    
                </a>
            </li>
            <li class="nav-item" style="width: 140px;">
                <a class="nav-link" data-toggle="tab" href="#school" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-school mr-2'></i>School
                    </span>    
                </a>
            </li>
            <li class="nav-item" style="width: 140px;">
                <a class="nav-link" data-toggle="tab" href="#address" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-map-alt mr-2'></i>Address
                    </span>     
                </a>
            </li>
        </ul>

        <div class="tab-content p-3 text-muted">
            <div class="tab-pane active" id="profile" role="tabpanel">
                <div class="row font-size-13 mt-3">
                    <div class="col-sm-4">
                        <h6 class="text-muted font-size-13"><i class="bx bxs-calendar mr-1 text-primary"></i> SPAS ID No.</h6>
                        <p class="font-weight-bold text-dark mb-0">Ra-ouf</p>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-muted font-size-13"><i class="bx bxs-calendar mr-1 text-primary"></i> Learner's Reference No.</h6>
                        <p class="font-weight-bold text-dark mb-0">Jumli</p>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-muted font-size-13"><i class="bx bxs-calendar mr-1 text-primary"></i> Category</h6>
                        <p class="font-weight-bold text-dark mb-0">Indanan</p>
                    </div>
                </div>
                <hr></hr>
                 <div class="row font-size-13 mt-3">
                    <div class="col-sm-4">
                        <h6 class="text-muted font-size-13"><i class="bx bxs-calendar mr-1 text-primary"></i> SPAS ID No.</h6>
                        <p class="font-weight-bold text-dark mb-0">Ra-ouf</p>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-muted font-size-13"><i class="bx bxs-calendar mr-1 text-primary"></i> Learner's Reference No.</h6>
                        <p class="font-weight-bold text-dark mb-0">Jumli</p>
                    </div>
                    <div class="col-sm-4">
                        <h6 class="text-muted font-size-13"><i class="bx bxs-calendar mr-1 text-primary"></i> Category</h6>
                        <p class="font-weight-bold text-dark mb-0">Indanan</p>
                    </div>
                </div>

            </div>

            <div class="tab-pane" id="school" role="tabpanel">
                <div class="row font-size-13 mt-3">
                    <div class="col-sm-12">
                        <h6 class="text-muted"><i class="bx bxs-school mr-1 text-primary"></i> School</h6>
                        <p class="font-weight-bold text-dark mb-0">Ateneo de Zamboanga University</p>
                    </div>
                   
                </div>
                 <div class="row font-size-13 mt-3">
                    <div class="col-sm-12">
                        <h6 class="text-muted"><i class="bx bxs-graduation mr-1 text-primary font-size-15"></i> Course</h6>
                        <p class="font-weight-bold text-dark mb-0">Bachelor of Science in Information Technology</p>
                    </div>
                </div>
                <div class="row font-size-13 mt-3">
                    <div class="col-sm-12">
                        <h6 class="text-muted "><i class="bx bxs-calendar mr-1 text-primary"></i>Year level</h6>
                        <p class="font-weight-bold text-dark mb-0">First year</p>
                    </div>
                </div>
            </div>

            <div class="tab-pane" id="address" role="tabpanel">
                <div class="row font-size-13 mt-3">
                    <div class="col-sm-12">
                        <h6 class="text-muted"><i class="bx bxs-school mr-1 text-primary"></i>Region</h6>
                        <p class="font-weight-bold text-dark mb-0">Region 9</p>
                    </div>
                   
                </div>
                 <div class="row font-size-13 mt-3">
                    <div class="col-sm-12">
                        <h6 class="text-muted"><i class="bx bxs-graduation mr-1 text-primary font-size-15"></i> Province</h6>
                        <p class="font-weight-bold text-dark mb-0">Zamboanga del Sur</p>
                    </div>
                </div>
                <div class="row font-size-13 mt-3">
                    <div class="col-sm-12">
                        <h6 class="text-muted "><i class="bx bxs-calendar mr-1 text-primary"></i>Municipality</h6>
                        <p class="font-weight-bold text-dark mb-0">Zamboanga City</p>
                    </div>
                </div>
            </div>

        </div>-->

        <div class="modal fade exampleModal" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <profile-edit @status="status" :user="user" ref="profile"></profile-edit>
        </div>

    </div>
</template>
<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                user: {}
            }
        },
        created(){
            this.user = this.$route.params.data;
        },  

        methods : {
            edit(){
                $("#editProfile").appendTo("body").modal('show');
            },

            status(){
                
            }
        }
    }
</script>