
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueRouter from 'vue-router';
import App from './App.vue';
import routes from './routes.js';
import store from './vuex/store.js';
import Notify from './lib/Notify';




Vue.use(Notify)
Vue.use(VueRouter)


Vue.config.debug = true;


if(window.Message) {
Vue.notify.success(Message)
   console.log(Message)
 }



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */
if (window.localStorage.getItem('user')) {
    store.dispatch('setUserInfo', JSON.parse(window.localStorage.getItem('user')));
}
if (window.localStorage.getItem('searchdata')){
    store.dispatch('serachArticle', JSON.parse(window.localStorage.getItem('searchdata')));
}




const router = new VueRouter({
    mode: 'history',
    base: __dirname,
    linkActiveClass: 'active',
    routes: routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        // this route requires auth, check if logged in
        // if not, redirect to login page.
        if (!store.state.userInfo) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            })
        } else {

            next()
        }
    } else {
        next() // 确保一定要调用 next()
    }
})


new Vue(
    Vue.util.extend({ router, store }, App)).$mount('#app')


