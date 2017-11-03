import Vue from 'vue'
import Router from 'vue-router'
import ExcelHome from '../components/Excel/Home.vue'
import ExcelList from '../components/Excel/List.vue'
import Error404 from '../components/Errors/404.vue'

Vue.use(Router)

const router = new Router({
    mode: 'history',
    routes: [{
            path: '/',
            name: 'home',
            component: ExcelHome
        },
        {
            path: '/list',
            name: 'list',
            component: ExcelList,
        },
        {
            path: '/404',
            component: Error404
        },
        {
            path: '*',
            redirect: '/404'
        }
    ]
});

export default router
