<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Affliation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="save">
                <div class="modal-body">
                    <div class="customerform" style="margin-left: 10px; margin-right: 10px;">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Organization: <span v-if="errors.organization" class="haveerror">({{ errors.organization[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="organization" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Address: <span v-if="errors.address" class="haveerror">({{ errors.address[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="address" style="text-transform: capitalize;">
                                </div>
                            </div> 
                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Position: <span v-if="errors.position" class="haveerror">({{ errors.position[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="position" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Duration: <span v-if="errors.duration" class="haveerror">({{ errors.duration[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="duration" style="text-transform: capitalize;">
                                </div>
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
    export default {
        props: ['user'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                id: '',
                organization: '',
                address: '',
                position: '',
                duration: ''
            }
        },

        methods : {
            save(){
                axios.post(this.currentUrl + '/request/history/store', {
                    id: this.id,
                    user: this.user,
                    organization: this.organization,
                    address: this.address,
                    position: this.position,
                    duration: this.duration,
                    type: 'Affliation'
                })
                .then(response => {
                    this.empty();
                    this.$emit('status',response.data.data);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            empty(){
                this.organization = '';
                this.duration = '';
                this.position = '';
                this.address = '';
                this.errors = [];
            }

        }
    }
</script>


