import hasLoggedIn from "../../middleware/hasLoggedInBackend";

const appRouter = [
    {
        path: '',
        name: 'app-list',
        component:  () => import('../../pages/backend/app/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/form',
        name: 'app-form',
        component:  () => import('../../pages/backend/app/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/detail',
        name: 'app-detail',
        component:  () => import('../../pages/backend/app/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default appRouter
