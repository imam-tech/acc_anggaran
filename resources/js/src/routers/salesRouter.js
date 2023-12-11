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
        path: 'customers',
        name: 'sales-customer-index',
        component:  () => import('../pages/sales/IndexCustomer'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'customers/:type/form',
        name: 'sales-customer-form',
        component:  () => import('../pages/sales/FormCustomer'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default salesRouter
