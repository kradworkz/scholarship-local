<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Employment History</h5>
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
                                    <label>Company: <span v-if="errors.company" class="haveerror">({{ errors.company[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="company" style="text-transform: capitalize;">
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
                                    <input type="text" class="form-control"  v-model="position" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Period: <span v-if="errors.period" class="haveerror">({{ errors.period[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="period" style="text-transform: capitalize;" placeholder="January 2020 - January 2021">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <i class="mdi mdi-alert-outline mr-2"></i>
                                    <div class="form-group" style="margin-top:-18px; margin-bottom: 2px;">         
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" v-model="job" class="custom-control-input" id="formrow-customCheck">
                                            <label class="custom-control-label font-size-12" for="formrow-customCheck">Is Job Related To Undergraduate Academic Training?</label>
                                        </div>
                                    </div>
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
                company: '',
                address: '',
                position: '',
                period: '',
                job: false
                
            }
        },

        methods : {
            save(){
                axios.post(this.currentUrl + '/request/history/store', {
                    id: this.id,
                    user: this.user,
                    company: this.company,
                    address: this.address,
                    position: this.position,
                    period: this.period,
                    job: this.job,
                    type: 'History'
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
                this.company = '';
                this.address = '';
                this.position = '';
                this.period = '';
                this.errors = [];
            }

        }
    }
</script>


