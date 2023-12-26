import hasLoggedIn from "../middleware/hasLoggedIn";

const purchaseRouter = [
    {
        path: '',
        name: 'sales-and-purchase-index',
        component:  () => import('../pages/purchase/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'sales-and-purchase-form',
        component:  () => import('../pages/purchase/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment/:id/:type/form',
        name: 'sales-and-purchase-payment-form',
        component:  () => import('../pages/purchase/PaymentForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment/:type/detail',
        name: 'sales-and-purchase-payment-detail',
        component:  () => import('../pages/purchase/PaymentDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/detail',
        name: 'sales-and-purchase-detail',
        component:  () => import('../pages/purchase/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default purchaseRouter
