<template>
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View Financial Benefit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive" v-if="financial.lists.length > 0">
                    <table class="table table-nowrap">
                        <thead class="thead-light">
                            <tr class="font-size-11">
                                <th class="text-center">Benefit Type</th>
                                <th class="text-center">Flag</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="list in financial.lists" v-bind:key="list.id">
                                <td class="text-center">{{list.benefit.name}}</td>
                                <td class="text-center">{{list.flag}}</td>
                                <td class="text-center">{{list.amount}}</td>
                                <td class="text-center font-size-12">{{list.created_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                financial: {
                    lists : {}
                },
                user: '',
                stipends: [],
                counts: this.$parent.counts,
            }
        },

        methods : {
            set(financial){
                this.financial = financial;
            },

           
        }
    }
</script>
