import hasLoggedIn from "../middleware/hasLoggedIn";

const taxRouter = [
    {
        path: '',
        name: 'accounting-tax-index',
        component:  () => import('../pages/tax/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default taxRouter
