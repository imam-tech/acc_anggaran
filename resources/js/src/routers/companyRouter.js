import hasLoggedIn from "../middleware/hasLoggedIn";

const companyRouter = [
    {
        path: '',
        name: 'company-index',
        component:  () => import('../pages/company/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/detail',
        name: 'company-detail',
        component:  () => import('../pages/company/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/admin',
        name: 'company-admin',
        component:  () => import('../pages/company/Admin'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default companyRouter
