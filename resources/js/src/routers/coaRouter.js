import hasLoggedIn from "../middleware/hasLoggedIn";

const coaRouter = [
    {
        path: '',
        name: 'coa-index',
        component:  () => import('../pages/coa/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'category',
        name: 'coa-category-index',
        component:  () => import('../pages/coa/CategoryIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/detail',
        name: 'coa-detail',
        component:  () => import('../pages/coa/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'category/:id/detail',
        name: 'coa-category-detail',
        component:  () => import('../pages/coa/CategoryDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default coaRouter
