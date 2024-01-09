import hasLoggedIn from "../middleware/hasLoggedIn";

const configurationRouter = [
    {
        path: 'company/',
        name: 'configuration-company-index',
        component:  () => import('../pages/configuration/company/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'company/:id/detail',
        name: 'configuration-company-detail',
        component:  () => import('../pages/configuration/company/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'company/:id/admin',
        name: 'configuration-company-admin',
        component:  () => import('../pages/configuration/company/Admin'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'user',
        name: 'configuration-user-index',
        component:  () => import('../pages/configuration/UserIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'flip',
        name: 'configuration-flip-index',
        component:  () => import('../pages/configuration/FlipIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'role',
        name: 'configuration-role-index',
        component:  () => import('../pages/configuration/RoleIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'permission',
        name: 'configuration-permission-index',
        component:  () => import('../pages/configuration/PermissionIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'project',
        name: 'configuration-company-project-index',
        component:  () => import('../pages/configuration/project/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'project/:id/:companyId/detail',
        name: 'configuration-company-project-detail',
        component:  () => import('../pages/configuration/project/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default configurationRouter
