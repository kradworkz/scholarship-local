<template>
    <div class="w-100 user-chat">
        <div class="card" :style="{ height: height + 'px' }">
            <div class="p-4">
                <div class="row">
                    <div class="col-md-4 row">
                    
                        <div class="col-sm-12">
                            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                                <i class="bx bx-info-circle mr-2"></i>
                               {{ allotment.remarks }}
                            </div>
                            <div>
                                <h5 class="font-size-13 float-right">{{ allotment.code }}</h5>
                                <p class="font-size-12 text-muted mb-0">Code :</p>
                                <hr></hr>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mt-3 mt-sm-0">
                                <h5 class="font-size-13 float-right">{{ allotment.check_no }}</h5>
                                <p class="font-size-12 text-muted mb-0">Check # :</p>
                                <hr></hr>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mt-3 mt-sm-0">
                                <h5 class="font-size-13 float-right">{{ allotment.checked_view }}</h5>
                                <p class="font-size-12 text-muted mb-0">Check Date :</p>
                                <hr></hr>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mt-3 mt-sm-0">
                                <h5 class="font-size-13 float-right">{{ allotment.credited_view }}</h5>
                                <p class="font-size-12 text-muted mb-0">Credited Date : </p>
                                <hr></hr>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="mt-3 mt-sm-0">
                                <h5 class="font-size-14 text-info float-right">₱{{ formatPrice(total) }}</h5>
                                <p class="font-size-12 text-muted mb-0">Total : </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-xl-12 form-inline">
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
                        </div>

                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap">
                                <thead class="thead-light font-size-11">
                                    <tr>
                                        <th style="width: 2%;"></th>
                                        <th>Expense</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Added By</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="list in allotment.lists" v-bind:key="list.id">
                                        <td>
                                        
                                        </td>
                                        <td>{{list.expense.name}}</td>
                                        <td class="text-center">{{list.amount}}</td>
                                        <td class="text-center font-size-11">{{list.user.profile.firstname}} {{list.user.profile.lastname}}</td>
                                        <td class="text-center">
                                            <a class="mr-3 text-warning" @click="edit(list)"><i class='bx bx-edit-alt'></i></a>
                                            <a class="text-danger"><i class='bx bx-trash'></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade exampleModal" id="newSub" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <accounting-allotment-create-sub :allotmentid="id" :expenses="expenses" @status="message" ref="create"></accounting-allotment-create-sub>
        </div>

    </div>
</template>

<script>
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                height: this.$parent.$parent.height,
                pagination: {},
                keyword: '',
                errors: [], 
                expenses: [],
                allotment: {},
                id : this.$route.params.id,
                editable : false
            }
        },

        created(){
            this.fetch();
            this.fetchExpenses();
        },

        computed: {
            total() {
                return this.allotment.lists.reduce((a, req) => {
                    this.tot = parseInt(a) + parseInt(req.amount.replace(/,/g, ''));
                    return this.tot;
                }, 0);
            }
        },

        methods : {
            fetch(){
                axios.get(this.currentUrl + '/request/allotment/'+this.$route.params.id)
                .then(response => {
                    this.allotment = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchExpenses() {
                axios.get(this.currentUrl + '/request/expenses')
                .then(response => {
                    this.expenses = response.data;
                })
                .catch(err => console.log(err));
            },

            addnew(){
                $("#newSub").modal('show');
                this.$refs.create.clear();
            },

            edit(list){
                this.editable = true;
                $("#newSub").modal('show');
                this.$refs.create.edit(list,true);
            },

            message(list){
                if(list){
                    if(this.editable == true){
                        let index = this.allotment.lists.findIndex(u => u.id === list.id);
                        this.$set(this.allotment.lists, index, list);
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                    }else{
                        this.allotment.lists.unshift(list);
                        Vue.$toast.success('<strong>Successfully Created</strong>', {
                            position: 'bottom-right'
                        });
                    }
                    $("#newAllotment").modal('hide');
                    this.editable = false;
                }
            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

        }
    }
</script>