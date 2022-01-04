<template>
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Expense Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                    
                    <div class="row customerform" style="margin-right: 10px; margin-left: 10px;">
                        
                        <div class="col-md-12 customerform" style="margin-top: 20px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Name: <span v-if="errors.name" class="haveerror">({{ errors.name[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="name" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Code: <span v-if="errors.code" class="haveerror">({{ errors.code[0] }})</span></label>
                                        <input type="text" class="form-control" v-model="code" style="text-transform: uppercase;">
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top: -7px;">
                                    <div class="form-group">
                                        <label>Type: <span v-if="errors.type" class="haveerror">({{ errors.type[0] }})</span></label>
                                          <multiselect 
                                            v-model="type" 
                                            :options="expenditures"
                                              label="name" track-by="id" 
                                            :allow-empty="false"
                                            :show-labels="false"
                                            placeholder="Select Type">
                                        </multiselect>
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
    import Multiselect from 'vue-multiselect';
    export default {
        props : ['expenditures'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                id: '',
                code: '',
                name: '',
                type: '',
                editable: false,
            }
        },
        
        methods : {
            create(){
                axios.post(this.currentUrl + '/request/admin/expense/store', {
                    id: this.id,
                    name: this.name,
                    code: this.code,
                    expenditure_id: this.type.id,
                    editable: this.editable
                })
                .then(response => {
                    this.$emit('status', response.data.data);
                    this.clear();
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                         this.isLoading = false;
                    }
                });
            },

            edit(expense,editable){
                this.id = expense.id;
                this.code = expense.code;
                this.name = expense.name;
                this.type = expense.type;
                this.editable = editable;
            },

            clear(){
                this.editable = false;
                $("#newExpense").modal("hide");
                this.errors = [];
                this.code = '';
                this.name = '';
                this.type = '';
            },

        }, components: { Multiselect }
    }
</script>