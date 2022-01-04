
<template>
    <div class="d-xl-flex">                
        <div class="w-100">
            <div class="card">
                <div class="card-body" :style="{ height: height + 'px' }">


                    <div class="row justify-content-center" v-if="entries.length == 0">
                        <div class="col-md-8 col-lg-6 col-xl-5">
                            <div class="p-2">
                                <div class="text-center">

                                    <div class="avatar-md mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bx-cloud-upload h1 mb-0 text-primary"></i>
                                        </div>
                                    </div>
                                    <div class="p-2 mt-4">
                                        <form @submit.prevent="preview" enctype="multipart/form-data">
                                            <h5>Import by batch</h5>
                                            <p class="text-muted">Please click download if you wish to create a data entry and attach then click preview to generate the entry</p>
                                            <input class="mt-2 mb-4" type="file" @change="uploadFieldChange"><span v-if="errors['files.'+0]" class="haveerror">(required)</span>
                                            <div class="mt-4">
                                                <button type="submit" class="btn btn-success w-lg">Preview</button>
                                                <a href="/export" class="btn btn-success w-lg">Download </a>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-else>
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Mobile</th>
                                    <th>Mother</th>
                                    <th>Father</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="entry in (index,entries)" v-bind:key="index">
                                    <td>{{entry.firstname}} {{entry.middlename}}, {{entry.lastname}}</td>
                                    <td>{{entry.gender}}</td>
                                    <td>{{entry.mobile}}</td>
                                    <td> {{entry.information.parents.mother}}</td>
                                    <td> {{entry.information.parents.father}}</td>
                                    <td> {{entry.category.name}} ({{entry.category.id}})</td>
                                    <td> {{entry.status.name}} ({{entry.status.id}})</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>

                    <loading :active.sync="isLoading" loader="dots" background-color="black" :is-full-page="fullPage"></loading>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Loading from 'vue-loading-overlay';
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                windowHeight: window.innerHeight,
                windowWidth: window.innerWidth,
                errors: [],
                entry: '',
                entries: [],
                isLoading: false,
                fullPage: true
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
                return Math.floor((this.height - 125) / 54);
            }
        },
        
        methods : {
            uploadFieldChange(e) {
                e.preventDefault();
                var file = e.target.files || e.dataTransfer.files;
                this.entry = file;
            },

            preview(){
                this.isLoading = true;
                let data = new FormData();
                data.append('import_file', this.entry[0]);

                axios.post(this.currentUrl + '/importExcel', data)
                .then(response => {
                   this.entries = response.data;
                   this.isLoading = false;
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            download(){
                axios.get(this.currentUrl + '/export')
                .then(response => {})
                .catch(err => console.log(err));
            }
        }, components : {Loading}
    }
</script>