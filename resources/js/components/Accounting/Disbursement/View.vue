<template>
     <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Disbursement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <p class="font-16 text-muted mb-2"></p>
                    <h5 class="text-dark">{{list.expense_id.name }}</h5>
                    <h4 class="text-info font-16">₱ {{ list.amount }}</h4>
                    <p class="text-muted">{{ list.remarks }}</p>
                        <div class="float-right ml-2" >
                            <p class="font-size-11"><i class="bx bx-calendar text-primary font-size-12 align-middle mr-1"></i> {{list.created_at}}</p>
                        </div>
                        <p class=" float-left font-size-12 mb-0">
                            <i class="bx bx-user-circle text-primary font-size-12 align-middle mr-1"></i>{{ list.added_by }}
                        </p>
                </div>
            </div>
           
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                list: {
                    expense_id : ''
                }
            }
        },

        methods : {
            set(list){
                this.list = list;
            }
        }
    }
</script>