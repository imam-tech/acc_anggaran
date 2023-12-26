import hasLoggedIn from "../middleware/hasLoggedIn";

const budgetRouter = [
    {
        path: '',
        name: 'accounting-budget-index',
        component:  () => import('../pages/budget/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'accounting-budget-index',
        component:  () => import('../pages/budget/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default budgetRouter
