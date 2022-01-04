<template>
<div>
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
    <!--<blockquote class="p-3 border-light border rounded ">
        <div class="text-center">
            <div class="row">
                <div class="col-sm-4">
                    <div>
                        <p class="font-size-10 text-muted mb-0">Categories</p>
                        <h5 class="font-size-12">Project</h5>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mt-4 mt-sm-0">
                        <p class="font-size-10 text-muted mb-0">Date</p>
                        <h5 class="font-size-12">10 Apr, 2020</h5>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="mt-4 mt-sm-0">
                        <p class="font-size-10 text-muted mb-0">Post by</p>
                        <h5 class="font-size-12">Gilbert Smith</h5>
                    </div>
                </div>
            </div>
        </div>
    </blockquote>-->
    <div class="table-responsive">
        <table class="table table-nowrap">
            <thead class="thead-light">
                <tr class="font-size-11">
                    <th style="width: 30%;">Title of Research</th>
                    <th class="text-center" style="width: 24%;">Source of fund</th>
                    <th class="text-center" style="width: 24%;">Involvement</th>
                    <th class="text-center" style="width: 23%;">Duration</th>
                    <th class="text-center" style="width: 23%;">Date Added</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="info in infos" v-bind:key="info.id">
                    <td>{{info.information.research}}</td>
                    <td class="text-center">{{info.information.fund_source}}</td>
                    <td class="text-center">{{info.information.nature_involvement}}</td>
                    <td class="text-center">{{info.information.duration}}</td>
                    <td class="text-center font-size-11">{{info.created_at}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade exampleModal" id="newResearch" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <employment-research-create @status="status" :user="id" ref="research"></employment-research-create>
    </div>
</div>
</template>

<script>
    export default {
        props: ['id','counts','height'],
        data(){
            return {
                currentUrl: window.location.origin, 
                keyword: '',
                pagination : {},
                infos: [],
                editable : false
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
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },

            fetch(page_url){
                let vm = this;
                page_url = page_url || this.currentUrl + '/request/information/Research/'+this.id+'/'+this.counts;

                axios.get(page_url)
                .then(response => {
                    this.infos = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            addnew(){
                $("#newResearch").appendTo("body").modal('show');
            },

            view(financial){
            },

            status(award){
                if(award){
                    if(this.editable == true){
                        let index = this.infos.findIndex(u => u.id === award.id);
                        this.$set(this.infos, index, award);
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                    }else{
                        this.infos.unshift(award);
                        Vue.$toast.success('<strong>Successfully Created</strong>', {
                            position: 'bottom-right'
                        });
                    }
                    $("#newResearch").modal('hide');
                    this.editable = false;
                }
            }
        }
    }
</script>