<template>
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" style="width: 140px;">
                <a class="nav-link active" data-toggle="tab" href="#lists" role="tab" aria-selected="true">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-user-detail mr-1'></i> Lists
                    </span>    
                </a>
            </li>
            <li class="nav-item" style="width: 140px;">
                <a class="nav-link" data-toggle="tab" href="#stipend" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-school mr-2'></i>Stipend
                    </span>    
                </a>
            </li>
            <li class="nav-item" style="width: 140px;">
                <a class="nav-link" data-toggle="tab" href="#breakdown" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-school mr-2'></i>Breakdown
                    </span>    
                </a>
            </li>
        </ul>

        <div class="tab-content mt-3 text-muted">
            <div class="tab-pane active" id="lists" role="tabpanel">
                <fi-lists :id="id" :height="height" :counts="counts"></fi-lists>
            </div>
            <div class="tab-pane" id="stipend" role="tabpanel">
                <fi-stipend :id="id" :height="height" :counts="counts"></fi-stipend>
            </div>

            <div class="tab-pane" id="breakdown" role="tabpanel">
                <fi-breakdown :id="id" :height="height" :counts="counts"></fi-breakdown>
            </div>
        </div>
        <!--<div class="col-md-4 mx-auto mt-5" v-else> 
            <img class="img-fluid" src="/images/svg/financial.svg">
            <div class="justify-content-center">
                <div class="col-xl-12">
                    <p class="text-muted text-center font-size-12 mt-4">Scholar has no financial benefit.</p>
                </div>
            </div>
            <button type="button" @click="addnew()" class="btn btn-danger btn-sm btn-block waves-effect waves-light mt-2">Add Financial Benefit</button>
        </div>-->

    </div>
</template>

<script>
    export default {
    data(){
        return {
            currentUrl: window.location.origin, 
            height: this.$parent.$parent.$parent.height,
            counts: this.$parent.$parent.$parent.counts,
            id: ''
        }
    },

    created(){
        this.id = this.$route.params.id;
    },

}
</script>
