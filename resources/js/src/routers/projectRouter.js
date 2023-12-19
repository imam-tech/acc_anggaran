import hasLoggedIn from "../middleware/hasLoggedIn";

const projectRouter = [
    {
        path: '',
        name: 'company-project-index',
        component:  () => import('../pages/project/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/:companyId/detail',
        name: 'company-project-detail',
        component:  () => import('../pages/project/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default projectRouter
