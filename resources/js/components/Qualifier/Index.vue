<template>
<div class="d-xl-flex">                
    <div class="w-100">
        <div class="card">
            <div class="card-body" :style="{ height: height + 'px' }">
                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 form-inline">
                        <router-link :to="{ name: 'qualifier/sync' }"> <button type="button" class="btn btn-danger waves-effect waves-light mr-2"><i class='bx bx-sync'></i></button></router-link>
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
                            <li class="list-inline-item d-none d-sm-inline-block font-size-12">
                                {{(pagination.current_page == 1) ? '1' : ((pagination.current_page -1) * pagination.per_page) + 1 }}-{{(pagination.last_page == pagination.current_page) ? pagination.total : pagination.current_page * pagination.per_page }} of {{pagination.total}}
                            </li>
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
                            <li v-if="show == true" class="list-inline-item d-non d-sm-inline-block">
                                  <div>
                                    <input type="text" style="width: 100px;" class="form-control bg-light border-light rounded" placeholder="Enter Year" v-model="year" @keyup="fetch()">
                                </div>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block">
                                <div class="dropdown">
                                    <button type="button" @click="yr" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-light" style="margin-right: -5px;"><span class="d-none d-sm-inline-block"> <i class='bx bx-calendar'></i></span></button>                                 
                                </div>
                            </li>
                            <li class="list-inline-item d-non d-sm-inline-block">
                                <div class="dropdown">
                                    <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-light" style="margin-right: -5px;"><span class="d-none d-sm-inline-block"> <i class='bx bx-category'></i></span></button>                                 
                                    <div class="dropdown-menu  dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                        <a @click="filter('-','category')" class="dropdown-item">All</a>
                                        <a @click="filter(status.id,'category')" class="dropdown-item" v-for="status in categories" v-bind:key="status.id">{{status.name}}</a>
                                    </div>
                                </div>
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
                                <th class="text-center">Program</th>
                                <th class="text-center">Education</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="user in users" v-bind:key="user.id">
                                <td>
                                    <div class="avatar-xs" v-if="user.avatar == 'n/a'">
                                        <span class="avatar-title rounded-circle">{{user.lastname.charAt(0)}}</span>
                                    </div>
                                    <div v-else>
                                        <img class="rounded-circle avatar-xs" :src="currentUrl+'/images/avatars/'+user.avatar" alt="">
                                    </div>
                                </td>
                                <td style="cursor: pointer;" @click="profile(user)">
                                    <h5 class="font-size-13 mb-0 text-dark">{{user.lastname}}, {{user.firstname}} {{user.middlename}}.</h5>
                                    <p class="font-size-11 text-muted mb-0">{{user.barangay}}, {{user.municipality}}, {{user.province}}</p>
                                </td>
                                <td class="text-center">
                                    <h5 class="font-size-13 mb-0 text-dark">{{user.category_id.name}}</h5>
                                    <p class="font-size-12 text-muted mb-0">{{user.applicant_id}}</p>
                                </td>
                                <td class="text-center">
                                    <h5 class="font-size-12 mb-0 text-dark">{{user.school}}</h5>
                                    <p class="font-size-11 text-muted mb-0">{{user.course}}</p>
                                </td>
                                <td class="text-right">
                                   <button type="button" @click="scholar(user)" class="btn btn-sm btn-danger w-sm waves-effect waves-light">Add Scholar</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade exampleModal" id="profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <qualifier-profile @status="message" ref="profile"></qualifier-profile>
    </div>
    <div class="modal fade exampleModal" id="scholar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <qualifier-scholar @status="message" ref="scholar"></qualifier-scholar>
    </div>
   
</div>
</template>

<script>
export default {
    data(){
        return {
            currentUrl: window.location.origin,
            windowHeight: window.innerHeight,
            windowWidth: window.innerWidth,
            errors: [],
            pagination: {},
            keyword: '',
            users : [],
            categories: [],
            category: '-',
            year: '-',
            show: false,
        }
    },

    computed : {
        height: function() {
            return this.windowHeight - 170;
        },
        width: function() {
            return this.windowWidth;
        },
        counts: function(){
            return Math.floor((this.height - 125) / 60);
        }
    },

    created(){
        this.fetch();
        this.categories = window.Categories;
    },

    methods: {
        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
                total: meta.total,
                per_page: meta.per_page,
            };
            this.pagination = pagination;
        },

        fetch(page_url) {
            let vm = this; let key,s,c,y;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            (this.category != '' && this.category != null) ? c = this.category : c = '-';
            (this.year != '' && this.year != null) ? y = this.year : y = '-';
            page_url = page_url || this.currentUrl + '/request/qualifiers/'+this.counts+'/'+c+'/'+y+'/'+key;

            axios.get(page_url)
            .then(response => {
                this.users = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        filter(data,type){
            switch(type){
                case 'category':
                    this.category = data;
                break;
            }

            let vm = this; let key;
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
            this.fetch(this.currentUrl + '/request/qualifiers/'+this.counts+'/'+this.category+'/'+this.year+'/'+key);
        },

        sync(){
            $("#sync").modal('show');
        },

        edit(user){
            this.editable = true;
            $("#new").modal('show');
            this.$refs.create.edit(user,true);
        },

        yr(){
            (this.show == false) ? this.show = true : this.show = false;
        },

        profile(user){
            this.$refs.profile.set(user);
            $("#profile").modal('show');
        },

        scholar(user){
            this.$refs.scholar.set(user);
            $("#scholar").modal('show');
        },

        message(user){
            if(user){
                if(this.editable == true){
                    let index = this.users.findIndex(u => u.id === user.id);
                    this.$set(this.users, index,   user);
                    Vue.$toast.success('<strong>Successfully Updated</strong>', {
                        position: 'bottom-right'
                    });
                }else{
                    // console.log(user);
                    this.users.unshift(user);
                    Vue.$toast.success('<strong>Successfully Created</strong>', {
                        position: 'bottom-right'
                    });
                }
                $("#new").modal('hide');
                this.editable = false;
            }
        },
    }, 
}
$(document).ready(function() {$("body").tooltip({ selector: '[data-toggle=tooltip]' });});
</script>