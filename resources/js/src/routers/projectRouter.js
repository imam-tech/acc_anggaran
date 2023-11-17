import hasLoggedIn from "../middleware/hasLoggedIn";

const projectRouter = [
    {
        path: '',
        name: 'project-index',
        component:  () => import('../pages/project/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/detail',
        name: 'project-detail',
        component:  () => import('../pages/project/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default projectRouter
