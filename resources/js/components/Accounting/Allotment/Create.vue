<template>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Allotment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                    
                    <div class="row customerform" style="margin-right: 10px; margin-left: 10px;">
                        
                        <div class="col-md-12 customerform" style="margin-top: 20px;">
                            <div class="row">
                                <div class="col-md-12" style="margin-top: -7px;">
                                    <div class="form-group">
                                        <label>Check #: <span v-if="errors.check_no" class="haveerror">({{ errors.check_no[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="check_no">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: -7px;">
                                    <div class="form-group">
                                        <label>Date Check: <span v-if="errors.checked_at" class="haveerror">({{ errors.checked_at[0] }})</span></label>
                                        <input type="date" class="form-control" v-model="check">
                                    </div>
                                </div>
                                <div class="col-md-6" style="margin-top: -7px;">
                                    <div class="form-group">
                                        <label>Date Credited: <span v-if="errors.credited_at" class="haveerror">({{ errors.credited_at[0] }})</span></label>
                                        <input type="date" class="form-control" v-model="credited">
                                    </div>
                                </div>
                                
                                <div class="col-md-12" style="margin-top: -7px;">
                                    <div class="form-group">
                                        <label>Remarks: <span v-if="errors.remarks" class="haveerror">({{ errors.remarks[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="remarks">
                                    </div>
                                </div>
                                                            
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><span v-if="editable == true">Update</span><span v-else>Create</span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                id: '',
                check_no: '',
                check: '',
                credited: '',
                remarks: '',
                editable: false,
            }
        },
        
        methods : {
            create(){
                axios.post(this.currentUrl + '/request/allotment/store', {
                    id: this.id,
                    check_no: this.check_no,
                    checked_at: this.check,
                    credited_at: this.credited,
                    remarks: this.remarks,
                    editable: this.editable,
                    type: 'Allotment'
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            edit(list,editable){
                this.id = list.id;
                this.check_no = list.check_no;
                this.check = list.checked_at;
                this.credited = list.credited_at;
                this.remarks = list.remarks;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                $("#newAllotment").modal("hide");
                this.errors = [];
                this.id = '';
                this.check_no = '';
                this.check = '';
                this.credited = '';
                this.remarks = '';
            },

        }
    }
</script>