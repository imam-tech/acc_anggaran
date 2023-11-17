import hasLoggedIn from "../middleware/hasLoggedIn";

const journalRouter = [
    {
        path: '',
        name: 'journal-index',
        component:  () => import('../pages/journal/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/detail',
        name: 'journal-detail',
        component:  () => import('../pages/journal/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default journalRouter
