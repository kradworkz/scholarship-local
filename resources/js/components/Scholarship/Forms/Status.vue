<template>
    <div class="modal-dialog modal-dialog-centered modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="save">
                <div class="modal-body">
                    <div class="customerform" style="margin-left: 10px; margin-right: 10px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Status: <span v-if="errors.status" class="haveerror">({{ errors.status[0] }})</span></label>
                                <multiselect 
                                v-model="status" 
                                :options="statuses" 
                                :show-labels="false" :allow-empty="false"
                                  label="name" track-by="id" 
                                placeholder="Select Status">
                                </multiselect>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
         
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                id: '',
                status: '',
                statuses: []
            }
        },

        created(){
             this.statuses = window.Statuses;
        },

        methods : {
            set(id,status){
                this.id = id;
                this.status = status;
            },

            save(){
                axios.post(this.currentUrl + '/request/scholar/status', {
                    id: this.id,
                    status: this.status.id,
                })
                .then(response => {
                     this.$emit('status',this.status);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            }

        }, components : {Multiselect}
    }
</script>


