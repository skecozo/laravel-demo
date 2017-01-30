import Example from './components/Example.vue'
import Parent from './components/Parent.vue'
import store from './vuex/store.js';
export default [
    {
        path: '/',
        component: Example,
        children: [
            {
                path: '/',
                redirect: '/home'
            },

            {
                path: 'home',
                component: require('./components/Home/Index.vue')
            },
            {
                path: 'article/:id',
                name: 'article',
                component: require('./components/Article/Index.vue')
            },
            {
                path: 'search',
                component: require('./components/Article/SearchArticle.vue')
            },

            {
                path: 'login',
                name:'login',
                component: require('./components/User/Login.vue')
            },
            {
                path: 'userhome/:id',
                name: 'userhome',
                component: require('./components/Home/Userinfo.vue')
            },
            {
                path: 'user',
              /*  beforeEnter: requireuserInfo,*/
                component: Parent,
                meta: { requiresAuth: true },
                children: [
                        {
                            path: '/',
                            component: require('./components/User/Index.vue')
                        },
                        {
                            path: 'message',
                            component: require('./components/User/Message.vue')
                        },
                        {
                            path: 'create',
                            component: require('./components/User/NewArticle.vue')
                        },
                ]
            },

        ],



    },
]

/*
function requireuserInfo(to, from, next) {
    if (store.state.userInfo) {
        return next()
    } else {
        return next('/login')
    }
}*/
