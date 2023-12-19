import hasLoggedIn from "../middleware/hasLoggedIn";

const coaRouter = [
    {
        path: '',
        name: 'accounting-coa-index',
        component:  () => import('../pages/coa/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'category',
        name: 'accounting-coa-category-index',
        component:  () => import('../pages/coa/CategoryIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/detail',
        name: 'accounting-coa-detail',
        component:  () => import('../pages/coa/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'category/:id/detail',
        name: 'accounting-coa-category-detail',
        component:  () => import('../pages/coa/CategoryDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default coaRouter
