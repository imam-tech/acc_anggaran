import hasLoggedIn from "../middleware/hasLoggedIn";

const salesRouter = [
    {
        path: '',
        name: 'sales-index',
        component:  () => import('../pages/sales/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'sales-form',
        component:  () => import('../pages/sales/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment/:id/:type/form',
        name: 'sales-payment-form',
        component:  () => import('../pages/sales/PaymentForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment/:type/detail',
        name: 'sales-payment-detail',
        component:  () => import('../pages/sales/PaymentDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/detail',
        name: 'sales-detail',
        component:  () => import('../pages/sales/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'customer',
        name: 'sales-customer-index',
        component:  () => import('../pages/sales/CustomerIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'customer/:type/form',
        name: 'sales-customer-form',
        component:  () => import('../pages/sales/CustomerForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default salesRouter
