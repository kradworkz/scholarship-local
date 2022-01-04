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

    <div class="table-responsive">
        <table class="table table-nowrap">
            <thead class="thead-light">
                <tr class="font-size-11">
                    <th style="width: 30%;">Organization</th>
                    <th class="text-center" style="width: 24%;">Address</th>
                    <th class="text-center" style="width: 23%;">Position</th>
                    <th class="text-center" style="width: 23%;">Duration</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="info in infos" v-bind:key="info.id">
                    <td>{{info.information.organization}}</td>
                    <td class="text-center">{{info.information.address}}</td>
                    <td class="text-center">{{info.information.position}}</td>
                    <td class="text-center">{{info.information.duration}}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade exampleModal" id="newAffliation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <employment-affliation-create @status="status" :user="id" ref="affliation"></employment-affliation-create>
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
                infos: []
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
                 let vm = this, key;
                // (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = '-';
                page_url = page_url || this.currentUrl + '/request/information/Affliation/'+this.id+'/'+this.counts;

                axios.get(page_url)
                .then(response => {
                    this.infos = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            addnew(){
                $("#newAffliation").appendTo("body").modal('show');
            },

            view(financial){
            },

            status(history){
                if(history){
                    if(this.editable == true){
                        let index = this.infos.findIndex(u => u.id === history.id);
                        this.$set(this.infos, index, history);
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-right'
                        });
                    }else{
                        this.infos.unshift(history);
                        Vue.$toast.success('<strong>Successfully Created</strong>', {
                            position: 'bottom-right'
                        });
                    }
                    $("#newAffliation").modal('hide');
                    this.editable = false;
                }
            }
        }
    }
</script>