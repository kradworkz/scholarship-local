<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="save">
                <div class="modal-body">
                    <div class="customerform" style="margin-left: 10px; margin-right: 10px;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email: <span v-if="errors.email" class="haveerror">({{ errors.email[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="user.email" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Mobile: <span v-if="errors.mobile" class="haveerror">({{ errors.mobile[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="user.mobile">
                                </div>
                            </div>
                            
                            <div class="col-md-12" style="margin-top: -10px;">
                                <hr></hr>
                            </div>

                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Mother: <span v-if="errors.mother" class="haveerror">({{ errors.mother[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="user.mother" style="text-transform: lowercase;">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Father: <span v-if="errors.father" class="haveerror">({{ errors.father[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="user.father">
                                </div>
                            </div>
                           
                           
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
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
            }
        },

        methods : {
            save(){
                axios.post(this.currentUrl + '/request/history/store', {
                    id: this.user.id,
                    email: this.user.email,
                    mobile: this.user.mobile,
                    father: this.user.father,
                    mother: this.user.mother
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


