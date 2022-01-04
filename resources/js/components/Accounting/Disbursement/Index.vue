<template>
<div class="d-xl-flex">                
    <div class="w-100">
        <div class="card">
            <div class="card-body" :style="{ height: height + 'px' }">
                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 form-inline">
                         <button type="button" @click="addnew" class="btn btn-danger waves-effect waves-light mr-2"><i class='bx bx-plus-medical'></i></button>
                        <form class="float-sm-right form-inline">
                            <div class="search-box">
                                <div class="position-relative">
                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                   <i class='bx bx-search-alt search-icon'></i>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-6 col-sm-6">
                        <ul class="list-inline user-chat-nav text-right mb-0 dropdown">
                            <li class="list-inline-item d-none d-sm-inline-block font-size-12">{{pagination.current_page}} out of {{pagination.last_page}}</li>
                            <li class="list-inline-item d-none d-sm-inline-block">
                                <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">
                                    <i class='bx bxs-chevron-left font-size-16'></i>
                                </a>
                            </li>
                            <li class="list-inline-item d-none d-sm-inline-block">
                                <a class="btn nav-btn" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">
                                    <i class='bx bxs-chevron-right font-size-16'></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 2%;"></th>
                                <th>Expense</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Created At</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="list in lists" v-bind:key="list.id">
                                <td>
                                  
                                </td>
                                <td>{{list.expense_id.name}}</td>
                                <td class="text-center">₱{{list.amount}}</td>
                                <td class="text-center">{{list.created_at}}</td>
                                <td class="text-right">
                                    <a class="mr-3 text-warning" @click="edit(list)"><i class='bx bx-edit-alt'></i></a>
                                    <a class="mr-3 text-info" @click="view(list)"><i class='bx bxs-show'></i></a>
                                    <a class="text-danger"><i class='bx bx-trash'></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade exampleModal" id="newDisbursement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <accounting-disbursement-create :expenses="expenses" @status="message" ref="create"></accounting-disbursement-create>
    </div>

    <div class="modal fade exampleModal" id="viewDisbursement" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <accounting-disbursement-view ref="view"></accounting-disbursement-view>
    </div>
</div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            counts: this.$parent.$parent.counts,
            height: this.$parent.$parent.height,
            errors: [],
            pagination: {},
            keyword: '',
            lists : [],
            expenses: []
        }
    },

    created(){
        this.fetch();
        this.fetchExpenses();
    },

    methods: {
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev
            };
            this.pagination = pagination;
        },

        fetchExpenses() {
            axios.get(this.currentUrl + '/request/expenses')
            .then(response => {
                this.expenses = response.data;
            })
            .catch(err => console.log(err));
        },

        fetch(page_url) {
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/disbursements/'+key+'/'+this.counts;

            axios.get(page_url)
            .then(response => {
                this.lists = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        addnew(){
            $("#newDisbursement").modal('show');
            this.$refs.create.clear();
        },

        edit(list){
            this.editable = true;
            $("#newDisbursement").modal('show');
            this.$refs.create.edit(list,true);
        },

        view(list){
            $("#viewDisbursement").modal('show');
            this.$refs.view.set(list);
        },

        message(list){
            console.log(list);
            if(list){
                if(this.editable == true){
                    let index = this.lists.findIndex(u => u.id === list.id);
                    this.$set(this.lists, index, list);
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }else{
                    this.lists.unshift(list);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                }
                $("#newDisbursement").modal('hide');
                this.editable = false;
            }
        }
    }, 
}
</script>