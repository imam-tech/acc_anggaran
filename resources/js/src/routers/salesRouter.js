import hasLoggedIn from "../middleware/hasLoggedIn";

const salesRouter = [
    {
        path: '',
        name: 'sales-and-purchase-index',
        component:  () => import('../pages/sales/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'sales-and-purchase-form',
        component:  () => import('../pages/sales/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment/:id/:type/form',
        name: 'sales-and-purchase-payment-form',
        component:  () => import('../pages/sales/PaymentForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment/:type/detail',
        name: 'sales-and-purchase-payment-detail',
        component:  () => import('../pages/sales/PaymentDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/detail',
        name: 'sales-and-purchase-detail',
        component:  () => import('../pages/sales/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default salesRouter
