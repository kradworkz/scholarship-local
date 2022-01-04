<template>
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead class="font-size-11">
                <tr>
                    <th rowspan="2" style="width: 30%;">#</th>
                    <th rowspan="2" class="text-center font-size-8" style="width: 10%;">One-time</th>
                    <th colspan="3" class="text-center" style="width: 30%;">
                        <div class="input-group input-group-sm">
                            <select class="custom-select custom-select-sm" v-model="ay">
                                <option value="2020-2021">2020-2021</option>
                                <option value="2021-2022">2021-2022</option>
                                <option value="2022-2023">2022-2023</option>
                                <option value="2023-2024">2023-2024</option>
                                <option value="2024-2025">2024-2025</option>
                            </select>
                            <div class="input-group-append">
                                <label class="input-group-text" style="width: 100px;"><span class="ml-2">Term A.Y</span></label>
                            </div>
                        </div>
                    </th>
                    <th colspan="4" class="text-center" style="width: 30%;">Academic Year</th>
                </tr>
                <tr>
                    <th class="text-center">1st</th>
                    <th class="text-center">2nd</th>
                    <th class="text-center">3rd</th>
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="breakdown in breakdowns" v-bind:key="breakdown.id">
                    <td>{{breakdown.name}}</td>
                    <td :class="'text-center '+list.selectable" v-for="list in breakdown.lists" v-bind:key="list.id">
                        <span v-if="list.data != ''" v-html="list.data.val"></span>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        props: ['id','counts','height'],
        data(){
            return {
                currentUrl: window.location.origin, 
                breakdowns: [],
                ay: '2020-2021'
            }
        },

        created(){
            this.fetch();
        },

        methods : {
            fetch(page_url) {
                let vm = this; let key;
                page_url = page_url || this.currentUrl + '/request/financial/breakdown/'+this.id;

                axios.get(page_url)
                .then(response => {
                    this.breakdowns = response.data;
                })
                .catch(err => console.log(err));
            },

        }
    }
</script>
<style>
    .unselectable {
        background-color: #ddd;
        cursor: not-allowed;
    }
</style>