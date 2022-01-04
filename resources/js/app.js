/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import VueRouter from 'vue-router';

Vue.component('users-index', require('./components/Admin/User/Index.vue').default);
Vue.component('user-create', require('./components/Admin/User/Create.vue').default);
Vue.component('user-status', require('./components/Admin/User/Status.vue').default);

Vue.component('logs-index', require('./components/Admin/Logs/Index.vue').default);
Vue.component('log-details', require('./components/Admin/Logs/Details.vue').default);

Vue.component('admin-dropdown', require('./components/Admin/Dropdowns/Index.vue').default);
Vue.component('admin-expenses', require('./components/Admin/Expenses/Index.vue').default);
Vue.component('admin-expense-create', require('./components/Admin/Expenses/Create.vue').default);

Vue.component('lists', require('./components/Admin/Lists.vue').default); // Agencies,Courses,Schools



// Vue.component('scholars-index', require('./components/Scholarship/Scholar/Index.vue').default);
// Vue.component('scholar-create', require('./components/Scholarship/Scholar/Create.vue').default);
// Vue.component('scholar-batch', require('./components/Scholarship/Scholar/Batch.vue').default);
// Vue.component('scholar-profile', require('./components/Scholarship/Scholar/Profile.vue').default);
// Vue.component('scholar-status', require('./components/Scholarship/Forms/Status.vue').default);

// Vue.component('form-financial', require('./components/Scholarship/Forms/Financial.vue').default);
// Vue.component('view-financial', require('./components/Scholarship/View/Financial.vue').default);

// Vue.component('fi-lists', require('./components/Scholarship/Scholar/Profile/Financial/Lists.vue').default);
// Vue.component('fi-stipend', require('./components/Scholarship/Scholar/Profile/Financial/Stipend.vue').default);
// Vue.component('fi-breakdown', require('./components/Scholarship/Scholar/Profile/Financial/Breakdown.vue').default);

// Vue.component('employment-info', require('./components/Scholarship/Scholar/Profile/Employment/Info.vue').default);
// Vue.component('employment-history', require('./components/Scholarship/Scholar/Profile/Employment/History.vue').default);
// Vue.component('employment-history-create', require('./components/Scholarship/Forms/History.vue').default);
// Vue.component('employment-awards', require('./components/Scholarship/Scholar/Profile/Employment/Award.vue').default);
// Vue.component('employment-award-create', require('./components/Scholarship/Forms/Award.vue').default);
// Vue.component('employment-research', require('./components/Scholarship/Scholar/Profile/Employment/Research.vue').default);
// Vue.component('employment-research-create', require('./components/Scholarship/Forms/Research.vue').default);
// Vue.component('employment-affliation', require('./components/Scholarship/Scholar/Profile/Employment/Affliation.vue').default);
// Vue.component('employment-affliation-create', require('./components/Scholarship/Forms/Affliation.vue').default);

// Vue.component('accounting-allotment-index', require('./components/Accounting/Allotment/Index.vue').default);
// Vue.component('accounting-allotment-create', require('./components/Accounting/Allotment/Create.vue').default);
// Vue.component('accounting-allotment-view', require('./components/Accounting/Allotment/View.vue').default);
// Vue.component('accounting-allotment-create-sub', require('./components/Accounting/Allotment/CreateSub.vue').default);

// Vue.component('accounting-disbursement-index', require('./components/Accounting/Disbursement/Index.vue').default);
// Vue.component('accounting-disbursement-create', require('./components/Accounting/Disbursement/Create.vue').default);
// Vue.component('accounting-disbursement-view', require('./components/Accounting/Disbursement/View.vue').default);

Vue.component('profile-edit', require('./components/Scholarship/Forms/Profile.vue').default);

Vue.component('qualifier-index', require('./components/Qualifier/Index.vue').default);
Vue.component('qualifier-sync', require('./components/Qualifier/Sync.vue').default);
Vue.component('qualifier-sync-modal', require('./components/Qualifier/Modals/SyncModal.vue').default);
Vue.component('qualifier-view', require('./components/Qualifier/View.vue').default);
Vue.component('qualifier-confirm', require('./components/Qualifier/Modals/Confirm.vue').default);
Vue.component('qualifier-profile', require('./components/Qualifier/Modals/Profile.vue').default);
Vue.component('qualifier-scholar', require('./components/Qualifier/Modals/Scholar.vue').default);

Vue.component('scholars-index', require('./components/Scholar/Index.vue').default);
Vue.component('scholar-profile', require('./components/Scholarship/Scholar/Profile.vue').default);

Vue.component('school-index', require('./components/School/Index.vue').default);

Vue.use(VueRouter)
import VueToast from 'vue-toast-notification';
Vue.use(VueToast);

import router from './Router/index';

const app = new Vue({
    data: { 
        currentUrl: window.location.origin,
        windowHeight: window.innerHeight,
        windowWidth: window.innerWidth,
    },
    
    computed : {
        height: function() {
            return this.windowHeight - 170;
        },
        width: function() {
            return this.windowWidth;
        },
        counts: function(){
            return Math.floor((this.height - 175) / 54);
        }
    },

    methods : {
        newFinancial(id){
            this.$refs.createFinancial.set(id);
            $("#newFinancial").modal('show');
        },

        viewFinancial(financial){
            this.$refs.viewFinancial.set(financial);
            $("#viewFinancial").modal('show');
        },

        message(status){
            if(status){
                Vue.$toast.success('<strong>Successfully Created</strong>', {
                    position: 'bottom-right'
                });
                $("#newFinancial").modal('hide');
                this.$refs.createFinancial.set(id);
            }
        },

        updateStatus(id,status){
            this.$refs.updateStatus.set(id,status);
            $("#updateStatus").modal('show');
        }
    },
    el: '#app',
    router,
});

// router.beforeEach((to, from, next) => {
//     app.loading = true
//     next()
// });
  
// router.afterEach(() => {
//     setTimeout(() => app.loading = false, 1000) // timeout for demo purposes
// });
