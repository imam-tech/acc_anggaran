import hasLoggedIn from "../middleware/hasLoggedIn";

const purchaseRouter = [
    {
        path: '',
        name: 'sales-index',
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
        path: 'suppliers',
        name: 'purchase-customer-index',
        component:  () => import('../pages/purchase/IndexSupplier'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'suppliers/:type/form',
        name: 'purchase-customer-form',
        component:  () => import('../pages/purchase/FormSupplier'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default purchaseRouter
