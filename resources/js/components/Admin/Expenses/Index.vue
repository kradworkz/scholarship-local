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
                                <th>Name</th>
                                <th class="text-center">Code</th>
                                <th class="text-center">Expenditure</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="expense in expenses" v-bind:key="expense.id">
                                <td>
                                  
                                </td>
                                <td>{{expense.name}}</td>
                                <td class="text-center">{{expense.code}}</td>
                                <td class="text-center">{{expense.type.name}}</td>
                                <td class="text-center">
                                    <a class="mr-3 text-warning" @click="edit(expense)"><i class='bx bx-edit-alt' ></i></a>
                                    <a class="text-danger"><i class='bx bx-trash'></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade exampleModal" id="newExpense" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <admin-expense-create @status="message" :expenditures="expenditures" ref="create"></admin-expense-create>
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
            expenses : [],
            expenditures: []
        }
    },

    created(){
        this.fetch();
        this.fetchExpenditures();
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

        fetch(page_url) {
            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            page_url = page_url || this.currentUrl + '/request/admin/expenses/'+key+'/'+this.counts;

            axios.get(page_url)
            .then(response => {
                this.expenses = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        fetchExpenditures() {
            axios.get(this.currentUrl + '/request/expenditures')
            .then(response => {
                this.expenditures = response.data.data;
            })
            .catch(err => console.log(err));
        },

        addnew(){
            $("#newExpense").modal('show');
            this.$refs.create.clear();
        },

        edit(expense){
            this.editable = true;
            $("#newExpense").modal('show');
            this.$refs.create.edit(expense,true);
        },

        message(expense){
            if(expense){
                if(this.editable == true){
                    let index = this.expenses.findIndex(u => u.id === expense.id);
                    this.$set(this.expenses, index, expense);
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }else{
                    this.expenses.unshift(expense);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                }
                $("#newExpense").modal('hide');
                this.editable = false;
            }
        }
    }, 
}
</script>