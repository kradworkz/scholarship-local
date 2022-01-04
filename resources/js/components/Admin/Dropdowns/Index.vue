    <template>
<div class="d-xl-flex">
    <div class="w-100">
        <div class="d-md-flex">
            
            <div class="card filemanager-sidebar mr-md-2">
                <div class="card-body">
                    <div class="d-flex flex-column h-100">
                        <div class="mb-4">
                            <div class="mb-3">
                                <div class="dropdown">
                                    <button @click="addnew" class="btn btn-light btn-block " type="button">
                                        <i class="mdi mdi-plus mr-1"></i> Create New
                                    </button>
                                </div>
                            </div>
                            <div class="mail-list mt-4">
                                <a @click="change('Group')" :class="{active:classification == 'Group'}">
                                   <i class='bx bx-list-ul mr-2'></i>Groups
                                </a>
                                <a @click="change('Category')" :class="{active:classification == 'Category'}">
                                    <i class='bx bx-list-check mr-2'></i>Categories
                                </a>
                                <a @click="change('Status')" :class="{active:classification == 'Status'}">
                                    <i class='bx bx-list-check mr-2'></i>Statuses
                                </a>
                                <a @click="change('Benefit Type')" :class="{active:classification == 'Benefit Type'}">
                                    <i class='bx bx-list-check mr-2'></i>Benefit Type
                                </a>
                                <a @click="change('S&T Categories')" :class="{active:classification == 'S&T Categories'}">
                                    <i class='bx bx-list-check mr-2'></i>S&T Categories
                                </a>
                                <a @click="change('Expenditure')" :class="{active:classification == 'Expenditure'}">
                                    <i class='bx bx-list-check mr-2'></i>Expenditures
                                </a>
                                <a @click="change('Term Type')" :class="{active:classification == 'Term Type'}">
                                    <i class='bx bx-list-check mr-2'></i>Term Type
                                </a>
                                <a @click="change('Grading System')" :class="{active:classification == 'Grading System'}">
                                    <i class='bx bx-list-check mr-2'></i>Grading System
                                </a>
                                <a @click="change('Class')" :class="{active:classification == 'Class'}">
                                    <i class='bx bx-list-check mr-2'></i>Class
                                </a>
                            </div>
                            <hr class="mb-4">
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-100">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-8 col-sm-8 ">
                                <div class="row">
                                    <div class="col-md-4" v-if="classification == 'Group'">
                                        <multiselect 
                                            v-model="type" 
                                            :options="groups"
                                            :allow-empty="false"
                                            deselect-label="Can't remove this value"
                                            @input="onChangeStatus()"
                                            >
                                        </multiselect>
                                    </div>
                                    <div class="col-md-6">
                                        <form class="form-inline">
                                            <div class="search-box">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                                    <i class='bx bx-search-alt search-icon'></i>
                                                </div>
                                            </div>
                                        </form>  
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-sm-4">
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
                            <table class="table table-centered table-nowrap mt-4">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th class="text-center" v-if="classification == 'Category'">Description</th>
                                        <th class="text-center" v-if="classification == 'Status' || classification == 'Benefit Type'">Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="list in lists" v-bind:key="list.id">
                                        <td v-if="classification == 'Salary'">Salary Grade {{list.name}}</td>
                                        <td v-else>{{list.name}}</td>
                                        <td class="text-center" v-if="classification == 'Group'">{{list.others}}</td>
                                        <td class="text-center" v-if="classification == 'Category' || classification == 'Expenditure'">{{list.others}}</td>
                                        <td class="text-center" v-if="classification == 'Status' || classification == 'Benefit Type'">{{list.type}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade exampleModal" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Lists</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <form @submit.prevent="create">
                            <div class="modal-body">
                                <div class="customerform">
                                    <div class="row" style="margin-bottom: -10px;">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Name: <span v-if="errors.name" class="haveerror">({{ errors.name[0] }})</span></label>
                                                <input type="text" class="form-control"  v-model="name" style="text-transform: capitalize;">
                                            </div>
                                        </div>
                                        <div class="col-md-12" v-if="classification == 'Group' || classification == 'Category' || classification == 'Expenditure'">
                                            <div class="form-group">
                                                <label>Others: <span v-if="errors.others" class="haveerror">({{ errors.others[0] }})</span></label>
                                                <input type="text" class="form-control"  v-model="others">
                                            </div>
                                        </div>
                                        <div class="col-md-12" style="margin-top: -7px;" v-if="classification == 'Status'">
                                            <div class="form-group">
                                                <label>Type: <span v-if="errors.type" class="haveerror">({{ errors.type[0] }})</span></label>
                                                <input type="text" class="form-control"  v-model="type">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" v-if="classification == 'Benefit Type'">
                                            <label>Type: <span v-if="errors.type" class="haveerror">({{ errors.type[0] }})</span></label>
                                            <multiselect 
                                                v-model="type" 
                                                :options="types"
                                                :allow-empty="false">
                                            </multiselect>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12" v-if="classification == 'Status'">
                                            <label>Color: <span v-if="errors.color" class="haveerror">({{ errors.color[0] }})</span></label>
                                            <multiselect 
                                                v-model="color" 
                                                :options="colors"
                                                :allow-empty="false">
                                            </multiselect>
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
            </div>
            
        </div>
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
            pagination: {},
            keyword: '',
            lists: [],
            id: '',
            name: '',
            type: '',
            color: '',
            others: '',
            classification: 'Group',
            editable: false,
            groups : ["Department","Employment Status","Unit"],
            colors : ["green","red","blue","yellow","black","gray"],
            types : ["Monthly","Term","One-time","Academic Year"],
        }
    },

    created(){
        this.fetch();
    },

    methods : {

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
                total: meta.total,
            };
            this.pagination = pagination;
        },

        fetch(page_url) {
            let vm = this; let key; let statust;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            (this.type != '' && this.type != null) ? statust = this.type : statust = '-';
            page_url = page_url || this.currentUrl + '/request/dropdown/'+this.classification+'/'+statust+'/'+key;

            axios.get(page_url)
            .then(response => {
                this.lists = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        onChangeStatus(){
            this.fetch();
        },

        create(){
            const form = new FormData();
            form.append('id', this.id);
            form.append('name', this.name);
            form.append('classification', this.classification);
            form.append('type', this.type);
            (this.color == "") ? '' :  form.append('color', this.color);
            (this.others == "") ? '' :  form.append('others', this.others);
            (this.editable == true) ? form.append('update', 'update') : form.append('update','create');


            axios.post(this.currentUrl + '/request/dropdown/store', form)
            .then(response => {
                $('#new').modal('hide');
                let statust;
                (this.type != '' && this.type != null) ? statust = this.type : statust = '-';
                let page_url = '/request/dropdown/'+this.classification+'/'+statust+'/-/?page=' + this.pagination.current_page;
                this.fetch(page_url);
                Vue.$toast.success('<strong>Successfully Updated</strong>', {
                    position: 'bottom-right'
                });
                this.clear();
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        addnew(){
            $("#new").modal('show');
        },

        change(type){
            this.classification = type;
            this.fetch();
            this.errors = [];
        },

        clear(){
            this.name = '';
            this.others = '';
            this.editable = false;
        }
     }, components: { Multiselect }
}
</script>