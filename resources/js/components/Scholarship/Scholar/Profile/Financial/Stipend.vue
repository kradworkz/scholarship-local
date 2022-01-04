<template>
<div>
    <simplebar :style="{height: (height - 100) + 'px' }"ref="feed">
        <table class="table table-nowrap font-size-10">
            <thead class="thead-light">
                <tr class="font-size-11">
                    <th>Month</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="stipend in stipends" v-bind:key="stipend.id">
                    <td class="font-weight-bold">{{stipend.month}}</td>
                    <td class="text-center"><span v-html="stipend.date"></span></td>
                    <td class="text-center"><span v-html="stipend.amount"></span></td>
                </tr>
            </tbody>
        </table>
    </simplebar>
</div>
</template>

<script>
    import simplebar from 'simplebar-vue';
    export default {
        props: ['id','counts','height'],
        data(){
            return {
                currentUrl: window.location.origin, 
                stipends: []
            }
        },

        created(){
            this.fetch();
        },

        methods : {

            fetch(page_url) {
                let vm = this; let key;
                page_url = page_url || this.currentUrl + '/request/financial/stipend/'+this.id;

                axios.get(page_url)
                .then(response => {
                    this.stipends = response.data;
                })
                .catch(err => console.log(err));
            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        }, components : { simplebar }
    }
</script>