import hasLoggedIn from "../middleware/hasLoggedIn";

const taxRouter = [
    {
        path: '',
        name: 'tax-index',
        component:  () => import('../pages/tax/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default taxRouter
