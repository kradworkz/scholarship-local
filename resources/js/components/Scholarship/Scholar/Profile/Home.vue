<template>
    <div class="col-md-12">
        <ul class="list-inline document-chat-nav text-right mb-0 dropdown">  
            <li class="list-inline-item d-non d-sm-inline-block"><button type="button" class="btn btn-sm btn-light w-md waves-effect waves-light">Financial</button></li>  
            <li class="list-inline-item d-non d-sm-inline-block"><button type="button" class="btn btn-sm btn-light w-md waves-effect waves-light">Employment</button></li>   
            <li class="list-inline-item d-non d-sm-inline-block"><button type="button" class="btn btn-sm btn-light w-md waves-effect waves-light">Enrollment</button></li>               
            <!--<li class="list-inline-item d-non d-sm-inline-block">
                <div class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="Filter by completion">
                    <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-light" style="margin-right: -5px;"><span class="d-none d-sm-inline-block"> <i class='bx bxs-school'></i></span></button>                                 
                    <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="height: auto; overflow-y: auto;">
                        <a class="dropdown-item">All</a>
                        <a class="dropdown-item">Completed</a>
                        <a  class="dropdown-item">Not completed</a>
                    </div>
                </div>
            </li>
                <li class="list-inline-item d-non d-sm-inline-block">
                <div class="dropdown" data-toggle="tooltip" data-placement="top" title="" data-original-title="Filter by completion">
                    <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-light" style="margin-right: -5px;"><span class="d-none d-sm-inline-block"> <i class='bx bx-money'></i></span></button>                                 
                    <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="height: auto; overflow-y: auto;">
                        <a class="dropdown-item">All</a>
                        <a class="dropdown-item">Completed</a>
                        <a  class="dropdown-item">Not completed</a>
                    </div>
                </div>
            </li>-->
        </ul>
        <hr></hr>
        <blockquote class="p-3 border-light border rounded ">
            <span class="float-right badge badge-info font-size-10 ml-2">Approved</span>
            <div class="d-flex">
                <div class="mr-3"><i class="bx bxs-quote-alt-left text-primary font-size-14"></i></div>
                <div>
                    <p class="mb-2 text-primary font-weight-bold">{{ user.lastname}}, {{ user.firstname}} {{ user.middlename }} </p>
                </div>
            </div>
            <div class="row font-size-12 mt-3">
               <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-category mr-1 text-primary"></i>Category</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.category_id.name}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-calendar mr-1 text-primary"></i>Awarded Year</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.awarded_year}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-credit-card mr-1 text-primary"></i>SPAS ID No.</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.spas}}</p>
                </div>
                <div class="col-sm-3">
                    <h6 class="text-muted font-size-12"><i class="bx bx-detail mr-1 text-primary"></i>Learner's Reference No.</h6>
                    <p class="font-weight-bold text-dark mb-0">{{user.lrn}}</p>
                </div>
            </div>
        </blockquote>
    </div>
</template>
<script>
    //this.$route.params.id; id
    //this.$parent.$parent.height height
    export default {
        props: ['user'],
        data(){
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.height,
                selects : [],
                selected: 1,
                id : this.$route.params.id
            }
        },

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
