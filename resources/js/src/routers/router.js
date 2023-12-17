import Vue from 'vue'
import Router from 'vue-router'

import hasLoggedIn from "../middleware/hasLoggedIn";
import ParentLayout from '../layouts/ParentLayout.vue'
import MenuLayout from '../layouts/MenuLayout.vue'
import AuthLayout from '../layouts/AuthLayout.vue'

import authRouter from './authRouter';
import companyRouter from './companyRouter';
import projectRouter from './projectRouter';
import taxRouter from './taxRouter';
import userRouter from './userRouter';
import transactionRouter from './transactionRouter';
import coaRouter from './coaRouter';
import journalRouter from './journalRouter';
import reportRouter from './reportRouter';
import settingRouter from './settingRouter';
import cashAndBankRouter from './cashAndBankRouter';
import salesRouter from './salesRouter';
import purchaseRouter from './purchaseRouter';
import productRouter from './productRouter';
import budgetRouter from './budgetRouter';
import manufactureRouter from './manufactureRouter';

Vue.use(Router)

const router = new Router({
    mode: 'history',
    base: '/',
    scrollBehavior() {
        return {
            x: 0,
            y: 0
        }
    },
    routes: [
        {
            path: '/app',
            component: ParentLayout,
            children: [
                {
                    path: '',
                    component:  () => import('../pages/Index'),
                    meta: {
                        middleware: hasLoggedIn,
                        pageTitle: 'Dashboard',
                    },
                },
                {
                    path: 'company',
                    component: MenuLayout,
                    children: companyRouter
                },
                {
                    path: 'project',
                    component: MenuLayout,
                    children: projectRouter
                },
                {
                    path: 'tax',
                    component: MenuLayout,
                    children: taxRouter
                },
                {
                    path: 'user',
                    component: MenuLayout,
                    children: userRouter
                },
                {
                    path: 'transaction',
                    component: MenuLayout,
                    children: transactionRouter
                },
                {
                    path: 'coa',
                    component: MenuLayout,
                    children: coaRouter
                },
                {
                    path: 'journal',
                    component: MenuLayout,
                    children: journalRouter
                },
                {
                    path: 'report',
                    component: MenuLayout,
                    children: reportRouter
                },
                {
                    path: 'setting',
                    component: MenuLayout,
                    children: settingRouter
                },
                {
                    path: 'cash-and-bank',
                    component: MenuLayout,
                    children: cashAndBankRouter
                },
                {
                    path: 'sales',
                    component: MenuLayout,
                    children: salesRouter
                },
                {
                    path: 'purchase',
                    component: MenuLayout,
                    children: purchaseRouter
                },
                {
                    path: 'product',
                    component: MenuLayout,
                    children: productRouter
                },
                {
                    path: 'budget',
                    component: MenuLayout,
                    children: budgetRouter
                },
                {
                    path: 'manufacture',
                    component: MenuLayout,
                    children: manufactureRouter
                },
            ]
        },
        {
            path: '/auth',
            component: AuthLayout,
            children: authRouter
        }
    ]
})

function nextFactory(context, middleware, index){
    const subsequentMiddleware = middleware[index];
    if (!subsequentMiddleware) return context.next;

    return (...parameters) =>{
        context.next(...parameters);
        const nextMiddleware = nextFactory(context, middleware, index + 1);
        subsequentMiddleware({ ...context, next: nextMiddleware });
    }
}
router.beforeEach((to, from, next) =>{
    if (to.meta.middleware){
        const middleware = Array.isArray(to.meta.middleware) ? to.meta.middleware : [to.meta.middleware];
        const context = {
            from, next, router, to
        };
        const nextMiddleware = nextFactory(context, middleware, 1);
        return middleware[0]({ ...context, next: nextMiddleware });
    }
    return next();
})

export default router
