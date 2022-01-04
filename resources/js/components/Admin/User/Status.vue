<template>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body"><br>
                    <p v-if="this.user.is_active == 1">Are you sure you want to <span class="font-weight-bold text-danger">deactivate</span> {{user.firstname}} {{user.lastname}}?</p>
                    <p v-else>Are you sure you want to <span class="font-weight-bold text-success">activate</span> {{user.firstname}} {{user.lastname}}?</p>
                    <div v-if="this.user.is_active == 1" class="alert alert-warning" role="alert">
                      This should blocked user from accessing the system.
                    </div>
                     <div v-else class="alert alert-warning" role="alert">
                      This should allow user from accessing the system.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                </div>
            </form>
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

        methods : {
            set(user){
                this.user = user;
            },

            create(){
                axios.post(this.currentUrl + '/request/admin/user/store', {
                    id: this.user.id,
                    is_active: (this.user.is_active == 1) ? 0 : 1,
                    editable: true
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                    $("#updatestatus").modal('hide');
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },
        }
    }
</script>