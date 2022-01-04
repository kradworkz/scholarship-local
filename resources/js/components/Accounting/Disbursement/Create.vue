<template>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Disbursement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                    
                    <div class="row customerform" style="margin-right: 10px; margin-left: 10px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Expense: <span v-if="errors.expense_id" class="haveerror">({{ errors.expense_id[0] }})</span></label>
                                <multiselect 
                                    v-model="expense_id" 
                                    :options="expenses"
                                    :show-labels="false"
                                    label="name" track-by="id" 
                                    :allow-empty="false"
                                    placeholder="Select Expense">
                                </multiselect>
                            </div>
                        </div>
                        <div class="col-md-12" style="margin-top: -7px;">
                            <div class="form-group">
                                <label>Amount: <span v-if="errors.amount" class="haveerror">({{ errors.amount[0] }})</span></label>
                                <input type="text" class="form-control" v-model="amount">
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><span v-if="editable == true">Update</span><span v-else>Create</span></button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        props : ['expenses'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                id: '',
                amount: '',
                expense_id: '',
                remarks: '',
                editable: false,
            }
        },
        
        methods : {
            create(){
                axios.post(this.currentUrl + '/request/disbursement/store', {
                    id: this.id,
                    allotment_id: this.allotmentid,
                    expense_id : this.expense_id.id,
                    amount: this.amount,
                    remarks: this.remarks,
                    editable: this.editable,
                    type: 'Lists'
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
                this.expense_id = list.expense_id;
                this.amount = list.amount;
                this.remarks = list.remarks;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                $("#newDisbursement").modal("hide");
                this.errors = [];
                this.id = '';
                this.amount = '';
                this.expense_id = '';
                this.remarks = '';
            },

        }, components : { Multiselect }
    }
</script>