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
                <center><span class="text-muted mb-4">Are you sure you want to sync the <span class="font-weight-bold text-danger"> {{ users.length }}</span> qualifiers?</span></center>
                <center><button type="button" @click="sync" class="mt-4 mb-4 btn btn-warning w-md waves-effect waves-light">SYNC</button></center>
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
                qualifiers: []
            }
        },

        methods : {
            sync(){
                this.isLoading = true;
                this.qualifiers = this.users;
                axios.post(this.currentUrl + '/qualifier/store', {
                    users: this.qualifiers,
                })
                .then(response => {
                    this.$emit('status', response.data);
                    this.isLoading = false;
                    $("#confirm").modal('hide');
                    Vue.$toast.success('<strong>Successfully Synced</strong>', {
                        position: 'bottom-right'
                    });
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                        this.isLoading = false;
                    }
                });
            }
        }
    }
</script>


