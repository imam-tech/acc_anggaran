import hasLoggedIn from "../middleware/hasLoggedIn";

const budgetRouter = [
    {
        path: '',
        name: 'sales-index',
        component:  () => import('../pages/budget/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'sales-index',
        component:  () => import('../pages/budget/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default budgetRouter
