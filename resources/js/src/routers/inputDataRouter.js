import hasLoggedIn from "../middleware/hasLoggedIn";

const inputDataRouter = [
    {
        path: 'cash-and-bank',
        name: 'input-data-cash-and-bank-index',
        component:  () => import('../pages/inputData/cashAndBank/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'cash-and-bank/:type/form',
        name: 'input-data-cash-and-bank-form',
        component:  () => import('../pages/inputData/cashAndBank/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'sales',
        name: 'input-data-sales-and-purchase-index',
        component:  () => import('../pages/inputData/sales/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'sales/:type/form',
        name: 'input-data-sales-and-purchase-form',
        component:  () => import('../pages/inputData/sales/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'sales/payment/:id/:type/form',
        name: 'input-data-sales-and-purchase-payment-form',
        component:  () => import('../pages/inputData/sales/PaymentForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'sales/payment/:type/detail',
        name: 'input-data-sales-and-purchase-payment-detail',
        component:  () => import('../pages/inputData/sales/PaymentDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'sales/:type/detail',
        name: 'input-data-sales-and-purchase-detail',
        component:  () => import('../pages/inputData/sales/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'purchase/',
        name: 'input-data-sales-and-purchase-index',
        component:  () => import('../pages/inputData/purchase/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'purchase/:type/form',
        name: 'input-data-sales-and-purchase-form',
        component:  () => import('../pages/inputData/purchase/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'purchase/payment/:id/:type/form',
        name: 'input-data-sales-and-purchase-payment-form',
        component:  () => import('../pages/inputData/purchase/PaymentForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'purchase/payment/:type/detail',
        name: 'input-data-sales-and-purchase-payment-detail',
        component:  () => import('../pages/inputData/purchase/PaymentDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'purchase/:type/detail',
        name: 'input-data-sales-and-purchase-detail',
        component:  () => import('../pages/inputData/purchase/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'journal/',
        name: 'input-data-sales-and-purchase-journal-index',
        component:  () => import('../pages/inputData/journal/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'journal/:id/detail',
        name: 'input-data-sales-and-purchase-journal-detail',
        component:  () => import('../pages/inputData/journal/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'journal/form/:id',
        name: 'input-data-sales-and-purchase-journal-form',
        component:  () => import('../pages/inputData/journal/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default inputDataRouter
