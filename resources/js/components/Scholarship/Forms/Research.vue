<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add R&D Involvement</h5>
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
                                    <label>Title of Research: <span v-if="errors.research" class="haveerror">({{ errors.research[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="research" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Source of fund: <span v-if="errors.fund" class="haveerror">({{ errors.fund[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="fund" style="text-transform: capitalize;">
                                </div>
                            </div> 
                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Nature of Involvement: <span v-if="errors.involvement" class="haveerror">({{ errors.involvement[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="involvement" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Duration: <span v-if="errors.duration" class="haveerror">({{ errors.duration[0] }})</span></label>
                                    <input type="text" class="form-control" v-model="duration">
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Location: <span v-if="errors.location" class="haveerror">({{ errors.location[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="location" style="text-transform: capitalize;">
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
                research: '',
                involvement: '',
                duration: '',
                fund: '',
                location: ''
            }
        },

        methods : {
            save(){
                axios.post(this.currentUrl + '/request/history/store', {
                    id: this.id,
                    user: this.user,
                    research: this.research,
                    fund: this.fund,
                    involvement: this.involvement,
                    duration: this.duration,
                    location: this.location,
                    type: 'Research'
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
                this.research = '';
                this.fund = '';
                this.involvement = '';
                this.duration = '';
                this.location = '';
                this.errors = [];
            }

        }
    }
</script>


