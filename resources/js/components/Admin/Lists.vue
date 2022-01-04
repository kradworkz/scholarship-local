<template>
<div class="d-xl-flex">                
    <div class="w-100">
        <div class="card">
            <div class="card-body" :style="{ height: height + 'px' }">

                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 form-inline">
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
                        </ul>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-centered table-nowrap">
                        <thead class="thead-light">
                            <tr class="font-size-12">
                                <th style="width: 2%;"></th>
                                <th>Name</th>
                                <th class="text-center" v-if="type == 'schools'">Class</th>
                                <th class="text-center" v-if="type == 'schools'">Term</th>
                                <th class="text-center" v-if="type == 'schools'">Grading</th>
                                <th class="text-center" v-if="type != 'schools'">Created at</th>
                                <th class="text-center" v-if="type != 'schools'">Updated at</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="list in lists" v-bind:key="list.id">
                                <td>
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle">{{list.name.charAt(0)}}</span>
                                    </div>
                                </td>
                                <td v-if="type == 'schools'">
                                    <h5 class="font-size-13 mb-0 text-dark">{{list.name}} - {{list.campus}}</h5>
                                    <p class="font-size-12 text-muted mb-0">{{list.address}}, {{list.municipality.name}}</p>
                                </td>
                                <td v-else-if="type == 'agencies'">
                                    <h5 class="font-size-13 mb-0 text-dark">{{list.name}}</h5>
                                    <p class="font-size-12 text-muted mb-0">{{list.acronym}} | {{list.code}}</p>
                                </td>
                                <td v-else>{{list.name}}</td>
                                <td class="text-center" v-if="type == 'schools'">{{list.class.name}}</td>
                                <td class="text-center" v-if="type == 'schools'">{{list.term.name}}</td>
                                <td class="text-center" v-if="type == 'schools'">{{list.grading.name}}</td>
                                <td class="text-center" v-if="type != 'schools'">{{list.created_at}}</td>
                                <td class="text-center" v-if="type != 'schools'">{{list.updated_at}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['type'],
        data(){
            return {
                currentUrl: window.location.origin,
                counts: this.$parent.$parent.counts,
                height: this.$parent.$parent.height, 
                errors: [],
                pagination: {},
                keyword: '',
                lists: []
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
                    per_page: meta.per_page,
                };
                this.pagination = pagination;
            },

            fetch(page_url){
                let vm = this; let key;
                (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';

                page_url = page_url || this.currentUrl + '/lists/'+this.type+'/'+key+'/'+this.counts;

                axios.get(page_url)
                .then(response => {
                    this.lists = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            }
        }
    }
</script>
