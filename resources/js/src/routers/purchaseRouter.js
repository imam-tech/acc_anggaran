import hasLoggedIn from "../middleware/hasLoggedIn";

const purchaseRouter = [
    {
        path: '',
        name: 'purchase-index',
        component:  () => import('../pages/purchase/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'purchase-form',
        component:  () => import('../pages/purchase/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment/:id/:type/form',
        name: 'purchase-payment-form',
        component:  () => import('../pages/purchase/PaymentForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment/:type/detail',
        name: 'purchase-payment-detail',
        component:  () => import('../pages/purchase/PaymentDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/detail',
        name: 'purchase-detail',
        component:  () => import('../pages/purchase/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'supplier',
        name: 'purchase-supplier-index',
        component:  () => import('../pages/purchase/SupplierIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'supplier/:type/form',
        name: 'purchase-supplier-form',
        component:  () => import('../pages/purchase/SupplierForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default purchaseRouter
