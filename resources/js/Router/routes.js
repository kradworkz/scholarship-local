import Profile from "../components/Scholarship/Scholar/Profile/Profile";
import Financial from "../components/Scholarship/Scholar/Profile/Financial/Index";
import Enrollment from "../components/Scholarship/Scholar/Profile/Enrollment";
import Home from "../components/Scholarship/Scholar/Profile/Home";
import Employment from "../components/Scholarship/Scholar/Profile/Employment/Index";

const routes = [{
        path: '/home',
        component: () => import('../Pages/Home.vue'),
        name: 'home'
    },
    {
        path: '/user',
        component: () => import('../Pages/User.vue'),
        name: 'user',
        beforeEnter: admin
    },
    {
        path: '/dropdowns',
        component: () => import('../Pages/Dropdown.vue'),
        name: 'dropdowns',
        beforeEnter: admin
    }, 
    {
        path: '/agencies',
        component: () => import('../Pages/Lists/Agency.vue'),
        name: 'agencies',
        beforeEnter: admin
    }, 
    {
        path: '/courses',
        component: () => import('../Pages/Lists/Course.vue'),
        name: 'courses',
        beforeEnter: admin
    }, 
    {
        path: '/schools',
        component: () => import('../Pages/Lists/School.vue'),
        name: 'schools',
        beforeEnter: admin
    }, 
    {
        path: '/expenses',
        component: () => import('../Pages/Expenses.vue'),
        name: 'expenses',
        beforeEnter: admin
    },
    {
        path: '/logs',
        component: () => import('../Pages/Log.vue'),
        name: 'logs',
        beforeEnter: admin
    },
    // FOR COORDINATORS
    // ********** Scholarsihp *******************888
    {
        path: '/school/lists',
        component: () => import('../Pages/School/Index.vue'),
        name: 'school/lists',
        beforeEnter: coordinator
    },
    {
        path: '/qualifier/lists',
        component: () => import('../Pages/Qualifier/Index.vue'),
        name: 'qualifier/lists',
        beforeEnter: coordinator
    },
    {
        path: '/qualifier/sync',
        component: () => import('../Pages/Qualifier/Sync.vue'),
        name: 'qualifier/sync',
        beforeEnter: coordinator
    },
    {
        path: '/scholar/lists',
        component: () => import('../Pages/Scholar/Index.vue'),
        name: 'scholar/lists',
        beforeEnter: coordinator
    },
    {
        path: '/scholar/import',
        component: () => import('../Pages/Scholar/Import.vue'),
        name: 'scholar/import',
        beforeEnter: coordinator
    },
    {
        path: '/scholar/:id',
        component: () => import('../Pages/Scholar/Profile.vue'),
        name: 'scholar/profile',
        beforeEnter: coordinator,
        children: [{
                path: "profile",
                name: "profile",
                component: Profile
            },
            {
                path: "financial",
                name: "financial",
                component: Financial
            },
            {
                path: "enrollment",
                name: "enrollment",
                component: Enrollment
            },
            {
                path: "",
                name: "home",
                component: Home
            },
            {
                path: "employment",
                name: "employment",
                component: Employment
            }
        ]
    },
    // ***************** ACCOUNTING **************************
    {
        path: '/financial-benefit',
        component: () => import('../Pages/Accounting/Financial.vue'),
        name: 'financial-benefit',
        beforeEnter: coordinator
    },
    {
        path: '/allotments',
        component: () => import('../Pages/Accounting/Allotment.vue'),
        name: 'allotments',
        beforeEnter: coordinator
    },
    {
        path: '/allotment/:id',
        component: () => import('../Pages/Accounting/AllotmentView.vue'),
        name: 'allotment/view',
        beforeEnter: coordinator,
    },
    {
        path: '/disbursements',
        component: () => import('../Pages/Accounting/Disbursement.vue'),
        name: 'disbursements',
        beforeEnter: coordinator
    },

];

function admin(to, from, next) {
    (window.User.role == "Super Administrator") ? next(true): next({
        path: '/home',
        compone
    });
}

function coordinator(to, from, next) {
    (window.User.role == "Scholarship Coordinator") ? next(true): next({
        path: '/home'
    });
}

function staff(to, from, next) {
    (window.User.role == "Scholarship Staff") ? next(true): next({
        path: '/home'
    });
}

export default routes;
