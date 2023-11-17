import hasLoggedIn from "../middleware/hasLoggedIn";

const transactionRouter = [
    {
        path: ':id/form',
        name: 'transaction-form',
        component:  () => import('../pages/transaction/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/detail',
        name: 'transaction-detail',
        component:  () => import('../pages/transaction/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: '',
        name: 'transaction-list',
        component:  () => import('../pages/transaction/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default transactionRouter
