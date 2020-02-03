import VueRouter from 'vue-router';


export const routes = [
    {
        path: '/dashboard',
        component: require('./views/dashboard').default
    },
    {
        path: '/users',
        component: require('./views/users').default
    },
    {
        path: '/departments',
        component: require('./views/departments').default
    },
    {
        path: '/roles',
        component: require('./views/roles').default
    },
    {
        path: '/permissions',
        component: require('./views/permissions').default
    }
];


// export default new VueRouter({
//     base: '/admin/',
//     mode: 'history',
//     routes,
//     linkActiveClass: 'active'
// });


