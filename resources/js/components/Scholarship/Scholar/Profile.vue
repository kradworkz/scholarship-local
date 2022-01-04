<template>
    <div>
        <div class="d-lg-flex">
            <div class="chat-leftsidebar mr-lg-4">
                <div class="">
                    <div class="py-4 border-bottom" style="margin-top: -20px;">
                        <div class="media">
                            <div class="align-self-center mr-3">
                               <img class="rounded avatar-md" :src="currentUrl+'/images/avatars/'+user.avatar" alt="">
                            </div>
                            <div class="media-body">
                                <h5 class="font-size-15 mt-0 mb-1 mt-1">
                                    {{user.firstname}} {{user.lastname}}
                                </h5>
                                <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle"></i>{{user.spas}}</p>
                                <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle"></i><span :class="'badge badge-'+user.status_id.color">{{user.status_id.name}} </span></p>
                            </div>

                            <div>
                                <div class="dropdown chat-noti-dropdown active">
                                    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-bell bx-tada"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" @click="update(user.id,user.status_id)">Update Status</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="search-box chat-search-box py-4">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <i class="bx bx-search-alt search-icon"></i>
                        </div>
                    </div>

                    <div @click="selected = 1"  class="card border shadow-none"  style="margin-bottom: 4px;">
                        <router-link :to="{ path: '/scholar/'+id }" class="text-body">
                            <div class="p-1">
                                <div class="d-flex mt-1">
                                    <div class="avatar-xs align-self-center ml-2 mr-2">
                                        <div class="avatar-title rounded bg-transparent">
                                            <i class='text-warning bx bx-home h4 mt-1'></i>
                                        </div>
                                    </div> 
                                    <div class="overflow-hidden mr-auto align-self-center">
                                        <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 1) ? 'text-primary' : ''">Home</h5> 
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>

                    <div @click="selected = 2" class="card border shadow-none"  style="margin-bottom:4px;">
                        <router-link :to="{ name: 'profile',  params: {data : user }}" class="text-body">
                            <div class="p-1">
                                <div class="d-flex mt-1">
                                    <div class="avatar-xs align-self-center ml-2 mr-2">
                                        <div class="avatar-title rounded bg-transparent">
                                            <i class='text-primary bx bx-user-circle h4 mt-1'></i>
                                        </div>
                                    </div> 
                                    <div class="overflow-hidden mr-auto align-self-center">
                                        <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 2) ? 'text-primary' : ''">Profile Information</h5> 
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>

                    <div @click="selected = 3" class="card border shadow-none"  style="margin-bottom: 4px;">
                        <router-link :to="{ name: 'financial'}" class="text-body">
                            <div class="p-1">
                                <div class="d-flex mt-1">
                                    <div class="avatar-xs align-self-center ml-2 mr-2">
                                        <div class="avatar-title rounded bg-transparent">
                                            <i class='text-danger bx bx-money h4 mt-1'></i>
                                        </div>
                                    </div> 
                                    <div class="overflow-hidden mr-auto align-self-center">
                                        <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 3) ? 'text-primary' : ''">Financial Benefits</h5> 
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>

                    <div @click="selected = 4" class="card border shadow-none"  style="margin-bottom: 4px;">
                       <router-link :to="{ name: 'enrollment' }" class="text-body">
                            <div class="p-1">
                                <div class="d-flex mt-1">
                                    <div class="avatar-xs align-self-center ml-2 mr-2">
                                        <div class="avatar-title rounded bg-transparent">
                                            <i class='text-success bx bxs-school h4 mt-1'></i>
                                        </div>
                                    </div> 
                                    <div class="overflow-hidden mr-auto align-self-center">
                                        <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 4) ? 'text-primary' : ''">Enrollment Information</h5> 
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>
                    
                    <div @click="selected = 5"  class="card border shadow-none"  style="margin-bottom: 4px;">
                        <router-link :to="{ name: 'employment' }" class="text-body">
                            <div class="p-1">
                                <div class="d-flex mt-1">
                                    <div class="avatar-xs align-self-center ml-2 mr-2">
                                        <div class="avatar-title rounded bg-transparent">
                                            <i class='text-info bx bx-user-pin h4 mt-1'></i>
                                        </div>
                                    </div> 
                                    <div class="overflow-hidden mr-auto align-self-center">
                                        <h5 class="font-size-12 text-truncate mt-1" :class="(selected == 5) ? 'text-primary' : ''">Employment History</h5> 
                                    </div>
                                </div>
                            </div>
                        </router-link>
                    </div>



                </div>
            </div>
            <div class="w-100 user-chat">
                <div class="card" :style="{ height: height + 'px' }">
                    <div class="p-4">
                        <div class="row">
                           <!-- <transition name="fade" :duration="1000"> -->
                                <router-view :user="user"></router-view>
                           <!-- </transition> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade exampleModal" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <scholar-status @status="status" ref="updateStatus"></scholar-status>
            </div>

        </div>
    </div>
</template>

<script>
    //this.$route.params.id; id
    //this.$parent.$parent.height height
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.height,
                user: {
                    status_id: {}
                },
                selects : [],
                selected: 1,
                id : this.$route.params.id
            }
        },

        created(){
            this.fetch();
        },

        methods : {
            fetch(){
                axios.get(this.currentUrl + '/request/scholar/'+this.$route.params.id)
                .then(response => {
                    this.user = response.data.data;
                })
                .catch(err => console.log(err));
            },

            update(id,status){
                this.$refs.updateStatus.set(id,status);
                $("#updateStatus").appendTo("body").modal('show');
            },

            status(status){
                this.user.status_id = status;
                $("#updateStatus").modal('hide');
                Vue.$toast.success('<strong>Successfully Updated</strong>', {
                    position: 'bottom-right'
                });
            }
        }
    }
</script>

<style>
.fade-enter-active, .fade-leave-active {
  transition-property: opacity;
  transition-duration: .25s;
}

.fade-enter-active {
  transition-delay: .25s;
}

.fade-enter, .fade-leave-active {
  opacity: 0
}
.page {
    position: fixed;
    width: 91%;
}
</style>
