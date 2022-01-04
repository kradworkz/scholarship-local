<template>
    <div class="modal-dialog modal-dialog-centered" role="document" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sync</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <center>We found <span class="font-weight-bold text-danger mb-4">{{ users.length }}</span> qualifiers available to sync.</center>
                <center><button type="button" @click="view" class="mt-4 mb-4 btn btn-warning w-md waves-effect waves-light">View Qualifiers</button></center>
            </div>
         
        </div>
    </div>
</template>
<script>
    export default {
        props: ['users'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
            }
        },

        methods : {
            view(){
                this.$emit('status',true);
            }
        }
    }
</script>


