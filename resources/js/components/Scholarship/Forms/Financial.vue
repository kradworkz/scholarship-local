<template>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Financial Benefit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                    
                    <div class="customerform" style="margin-left: 10px; margin-right: 10px;">
                            <!--<div class="form-group mb-0" style="margin-top: -10px;">
                                <label for="cardnumberInput">Disbursement Voucher</label>
                                <input type="text" class="form-control" id="cardnumberInput" placeholder="0000 0000 0000 0000">
                            </div>-->
                        <div class="row">
                                <div class="col-lg-4">
                                <div class="form-group mt-2 mb-0">
                                    <label>Academic Year <span v-if="errors.ay" class="haveerror">({{ errors.ay[0] }})</span></label>
                                    <multiselect 
                                        v-model="ay" 
                                        :options="ays"
                                        :allow-empty="false">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mt-2 mb-0">
                                    <label for="cardnameInput">School Session <span v-if="errors.type" class="haveerror">({{ errors.type[0] }})</span></label>
                                    <multiselect 
                                        v-model="type" 
                                        :options="types"
                                        :allow-empty="false">
                                    </multiselect>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group mt-2 mb-0">
                                    <label for="expirydateInput">Release Type <span v-if="errors.release" class="haveerror">({{ errors.release[0] }})</span></label>
                                    <multiselect 
                                        v-model="release" 
                                        :options="releases"
                                        :allow-empty="false">
                                    </multiselect>
                                </div>
                            </div>
                            
                            <div class="col-md-12 mt-3">
                                <hr>
                                <button v-if="benefits.length != 0" @click="add" style="margin-top: -55px;" class="btn btn-sm btn-primary pull-right" type="button">Add more</button>
                            </div>
                            
                            <div class="col-md-12" v-for="(list, index) in lists" v-bind:key="'a-'+list.id+index" style="margin-top: -5px;">   
                                <div class="row">
                                    <div class="col-lg-4" v-if="list.benefit != undefined && list.benefit.name == 'Stipend'">
                                        <div class="row">
                                            <div class="col-md-11">
                                                <div class="form-group mt-2 mb-0">
                                                    <multiselect 
                                                        deselect-label="Can't remove"  
                                                        v-model="list.benefit" 
                                                        :options="benefits"
                                                        @input="onChange(list.benefit.id)" 
                                                        :show-labels="false" :allow-empty="false" 
                                                        placeholder="Select Benefit Type" label="name" track-by="id">
                                                    </multiselect>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-1">
                                                <a ><i @click="wew(index)" class='bx bx-plus-circle font-size-22 mt-3 text-warning float-left' style="margin-left: -15px;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" v-else>
                                        <div class="form-group mt-2 mb-0">
                                            <multiselect 
                                                deselect-label="Can't remove"  
                                                v-model="list.benefit" 
                                                :options="benefits"
                                                @input="onChange(list.benefit.id)" 
                                                :show-labels="false" :allow-empty="false" 
                                                placeholder="Select Benefit Type" label="name" track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" v-if="list.benefit != undefined">
                                        <div class="row" v-if="list.benefit.name == 'Stipend'">
                                            <div class="col-md-12" v-for="(flg, index) in list.flag" v-bind:key="'c-'+index">
                                                <div :class="(index == 0) ? 'form-group mt-2 mb-0' : 'form-group mt-1 mb-0'">
                                                    <multiselect 
                                                        v-model="flg.val"
                                                        :options="months"
                                                        label="name" track-by="id"
                                                        :multiple="false"
                                                        class="haha"
                                                        :allow-empty="false">
                                                    </multiselect>
                                                </div>
                                            </div>
                                        </div>
                            
                                        <div class="form-group mt-2 mb-0" v-else-if="list.benefit.name == 'Tuition' || list.benefit.name == 'Book Allowance'">
                                            <multiselect 
                                                v-model="list.flag" 
                                                :options="terms"
                                                :allow-empty="false">
                                            </multiselect>
                                        </div>
                                        <div class="form-group mt-2 mb-0" v-else-if="list.benefit.name == 'Transportation'">
                                            <input type="text" class="form-control" v-model="list.flag = currentYear" disabled>
                                        </div>
                                        <div class="form-group mt-2 mb-0" v-else>
                                            <input type="text" class="form-control" v-model="list.flag = 'n/a'" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4" v-else>
                                            <div class="form-group mt-2 mb-0">
                                            <input type="text" class="form-control" value="n/a" disabled>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="row" v-for="(amount, i) in list.amount" v-bind:key="'a-'+amount+i">
                                            <div class="col-md-11">
                                                <div class="form-group mt-2 mb-0">
                                                    <input type="text" class="form-control" v-model="amount.val" placeholder="Enter Amount">
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                                <a v-if="i == 0"><i @click="del(index)" class='bx bx-trash font-size-22 mt-3 float-left' style="margin-left: -15px;"></i></a>
                                                <a v-else><i @click="rmv(index,i)" class='bx bx-trash text-warning font-size-22 mt-3 float-left' style="margin-left: -15px;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                
                    <h5 class="font-size-14 mr-auto"><i class="bx bx-wallet text-primary font-size-16 align-middle mr-1"></i> Php {{formatPrice(tot)}}</h5>
                    <button type="submit" class="btn btn-primary">Create</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
         
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [], 
                benefits: [],
                benefit: '',
                releases: ["Full","Partial"],
                release: '',
                types: ["Regular","Summer"],
                type: '',
                currentYear: new Date().getFullYear()+'-'+(new Date().getFullYear()+1), 
                amount: '',
                flags: ["Monthly","Term","Academic Year"],
                flag: '',
                lists: [{
                        flag: [{val: ''}],
                        amount : [{val: 0}]
                    }
                ],
                removes: [],
                total: '',
                ays : [
                    (new Date().getFullYear()-1)+'-'+(new Date().getFullYear()),
                    new Date().getFullYear()+'-'+(new Date().getFullYear()+1),
                    (new Date().getFullYear()+1)+'-'+(new Date().getFullYear()+2)
                ],
                ay: '',
                months: [
                    {id : 1, name: 'January'},
                    {id : 2, name: 'Febuary'},
                    {id : 3, name: 'March'},
                    {id : 4, name: 'April'},
                    {id : 5, name: 'May'},
                    {id : 6, name: 'June'},
                    {id : 7, name: 'July'},
                    {id : 8, name: 'August'},
                    {id : 9, name: 'September'},
                    {id : 10, name: 'October'},
                    {id : 11, name: 'November'},
                    {id : 12, name: 'December'}
                ],
                terms: ["1st term","2nd term","3rd term"],
                tot2: '',
                monthly: false,
                user: ''
               
            }
        },

        created(){
            this.benefits = window.Benefits;
            this.total = this.benefits.length;
        },

        computed : {
            tot() {
                return this.lists.reduce((a, req) => {
                    var ba = Number(req.amount);
                    this.tot2 = parseInt(a) + parseInt(ba);
                    return this.tot2;
                }, 0);
            }
        },
        
        methods : {
            set(id){
                this.user = id;
            },

            create(){
                axios.post(this.currentUrl + '/request/financial/store', {
                    ay: this.ay,
                    release: this.release,
                    type: this.type,
                    lists: this.lists,
                    user: this.user
                })
                .then(response => {
                    this.$emit('status', true);
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            add() {
                 if(this.lists.length <= this.total){
                    if(typeof this.lists[this.lists.length-1].benefit !== 'undefined'){
                        this.lists.push({amount: [{val:0}]})
                    }
                }
            },

            del(index) {
                if(this.lists.length > 1){
                    this.benefits.push(this.lists[index].benefit);
                    this.lists.splice(index, 1);
                    this.removes.splice(index, 1);
                }
            },

            wew(index){
                let arr, arr2;
                arr = this.lists[index].amount;
                arr.push({val:0});

                arr2 = this.lists[index].flag;
                arr2.push({val : ''});
            },

            rmv(index,i){
                this.lists[index].amount.splice(i, 1);
                this.lists[index].flag.splice(i, 1);
            },

            onChange(ids){
                var index = this.benefits.map(x => {
                    return x.id;
                }).indexOf(ids);

                // (this.benefits[index].name == 'Stipend') ? this.b = true : this.b = false ; 
        
                this.removes.push(this.benefits[index])
                this.benefits.splice(index, 1);

                for(var i=0; i < this.removes.length; i++){
                    let x = this.lists.some(
                        l => (
                            l.benefit.id === this.removes[i].id
                        )
                    )
                    if (!x) {
                        this.benefits.push(this.removes[i]);
                        this.removes.splice(i, 1);
                    }
                } 

            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },

        }, components : {Multiselect}
    }
</script>

<style>
.multiselect__tag{
    margin-bottom: -5px !important;
    margin-top: -5px;
    font-size: 10px;
    margin-right: 3px;
}
</style>
