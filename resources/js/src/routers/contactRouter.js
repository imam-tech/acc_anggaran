import hasLoggedIn from "../middleware/hasLoggedIn";

const contactRouter = [
    {
        path: '',
        name: 'sales-and-purchase-customer-index',
        component:  () => import('../pages/contact/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'sales-and-purchase-customer-form',
        component:  () => import('../pages/contact/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default contactRouter
