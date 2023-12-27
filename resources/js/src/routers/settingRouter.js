import hasLoggedIn from "../middleware/hasLoggedIn";

const settingRouter = [
    {
        path: '',
        name: 'setting-index',
        component:  () => import('../pages/setting/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'role',
        name: 'setting-role',
        component:  () => import('../pages/setting/Role'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'permission',
        name: 'setting-permission',
        component:  () => import('../pages/setting/Permission'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment-method',
        name: 'other-list-product-setting-pm',
        component:  () => import('../pages/setting/PaymentMethod'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default settingRouter
