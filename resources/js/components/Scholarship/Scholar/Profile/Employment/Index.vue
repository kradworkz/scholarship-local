<template>
    <div class="col-md-12">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item" style="width: 160px;">
                <a class="nav-link active" data-toggle="tab" href="#information" role="tab" aria-selected="true">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-user-detail mr-1'></i>Information
                    </span>    
                </a>
            </li>
            <li class="nav-item" style="width: 160px;">
                <a class="nav-link" data-toggle="tab" href="#history" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-school mr-2'></i> History
                    </span>    
                </a>
            </li>
            <li class="nav-item" style="width: 160px;">
                <a class="nav-link" data-toggle="tab" href="#affliation" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-school mr-2'></i> Affliation
                    </span>    
                </a>
            </li>
            <li class="nav-item" style="width: 160px;">
                <a class="nav-link" data-toggle="tab" href="#award" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-school mr-2'></i> Awards
                    </span>    
                </a>
            </li>
            <li class="nav-item" style="width: 160px;">
                <a class="nav-link" data-toggle="tab" href="#research" role="tab" aria-selected="false">
                    <span class="d-none d-sm-block">
                        <i class='bx bxs-school mr-2'></i> R&D
                    </span>    
                </a>
            </li>
        </ul>
         <div class="tab-content mt-3 text-muted">
            <div class="tab-pane active" id="information" role="tabpanel">
                <employment-info :id="id" :height="height" :counts="counts"></employment-info>
            </div>
            <div class="tab-pane" id="history" role="tabpanel">
                <employment-history :id="id" :height="height" :counts="counts"></employment-history>
            </div>
            <div class="tab-pane" id="affliation" role="tabpanel">
                <employment-affliation :id="id" :height="height" :counts="counts"></employment-affliation>
            </div>
            <div class="tab-pane" id="award" role="tabpanel">
                <employment-awards :id="id" :height="height" :counts="counts"></employment-awards>
            </div>
            <div class="tab-pane" id="research" role="tabpanel">
                <employment-research :id="id" :height="height" :counts="counts"></employment-research>
            </div>
        </div>
        <!--<div class="col-md-4 mx-auto mt-5"> 
            <img class="img-fluid" src="/images/svg/employment.svg">
            <div class="justify-content-center">
                <div class="col-xl-12">
                    <p class="text-muted text-center font-size-12 mt-4">Scholar has no Employment History.</p>
                </div>
            </div>
            <button type="button" class="btn btn-info btn-sm btn-block waves-effect waves-light mt-2">Add Scholar Employment</button>
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
        }
    }
</script>

