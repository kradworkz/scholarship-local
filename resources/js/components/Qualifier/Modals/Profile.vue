<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <blockquote class="p-3 border-light border rounded">
                    <div class="d-flex">
                        <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                        <div>
                            <p class="mb-2 font-weight-bold" v-bind:class="[(user.gender == 0? 'text-danger' : 'text-primary')]">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }} <span class="text-muted font-size-11 ml-2">(LRN : {{user.lrn}})</span> </p>
                        </div>
                    </div>
                    <div class="row font-size-11 mt-3">
                        <div class="col-sm-3">
                            <h6 class="text-muted font-size-12"><i class="bx bx-category mr-1 text-primary"></i>Category</h6>
                            <p class="font-weight-bold text-dark mb-0">{{user.category_id.name}}</p>
                        </div>
                        <div class="col-sm-3">
                            <h6 class="text-muted font-size-12"><i class="bx bx-calendar mr-1 text-primary"></i>Birthday</h6>
                            <p class="font-weight-bold text-dark mb-0">{{user.birthday}}</p>
                        </div>
                        <div class="col-sm-3">
                            <h6 class="text-muted font-size-12"><i class="bx bx-phone mr-1 text-primary"></i>Mobile</h6>
                            <p class="font-weight-bold text-dark mb-0">{{user.mobile}}</p>
                        </div>
                        <div class="col-sm-3">
                            <h6 class="text-muted font-size-12"><i class="bx bx-mail-send mr-1 text-primary"></i>Email</h6>
                            <p class="font-weight-bold text-dark mb-0">{{user.email}}</p>
                        </div>
                        <div class="col-sm-12"><hr></hr></div>
                        <div class="col-sm-6">
                            <h6 class="text-muted font-size-12"><i class="bx bxs-school mr-1 text-primary"></i>Education</h6>
                            <p class="font-weight-bold text-dark mb-0">{{user.school}}</p>
                            <p class="text-dark mb-0">{{user.course}}</p>
                        </div>
                        <div class="col-sm-6">
                            <h6 class="text-muted font-size-12"><i class="bx bxs-map mr-1 text-primary"></i>Address</h6>
                            <p class="font-weight-bold text-dark mb-0">{{user.barangay}} {{user.municipality}}, {{user.province}}</p>
                            <p class="text-dark mb-0">{{user.birth_place}}</p>
                        </div>
                    </div>
                </blockquote>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                user: {
                    category_id : {}
                }
            }
        },

        methods : {
            set(data){
                this.user = data;
            }
        }
    }
</script>


