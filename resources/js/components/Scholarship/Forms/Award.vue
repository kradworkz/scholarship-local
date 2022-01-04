<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Award</h5>
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
                                    <label>Title of Award: <span v-if="errors.award" class="haveerror">({{ errors.award[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="award" style="text-transform: capitalize;">
                                </div>
                            </div>
                            <div class="col-md-7" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Awarding Body: <span v-if="errors.body" class="haveerror">({{ errors.body[0] }})</span></label>
                                    <input type="text" class="form-control"  v-model="body" style="text-transform: capitalize;">
                                </div>
                            </div> 
                            <div class="col-md-5" style="margin-top: -10px;">
                                <div class="form-group">
                                    <label>Date: <span v-if="errors.given" class="haveerror">({{ errors.given[0] }})</span></label>
                                    <input type="date" class="form-control" v-model="given" style="text-transform: capitalize;">
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
                award: '',
                body: '',
                given: ''
            }
        },

        methods : {
            save(){
                axios.post(this.currentUrl + '/request/history/store', {
                    id: this.id,
                    user: this.user,
                    award: this.award,
                    body: this.body,
                    given: this.given,
                    type: 'Award'
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
                this.award = '';
                this.body = '';
                this.given = '';
                this.errors = [];
            }

        }
    }
</script>


