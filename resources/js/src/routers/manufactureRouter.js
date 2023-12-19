import hasLoggedIn from "../middleware/hasLoggedIn";

const manufactureRouter = [
    {
        path: 'product',
        name: 'manufacture-index',
        component:  () => import('../pages/manufacture/ProductIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product/:type/form',
        name: 'manufacture-form',
        component:  () => import('../pages/manufacture/ProductForm'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product/:type/detail',
        name: 'manufacture-detail',
        component:  () => import('../pages/manufacture/ProductDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'semi-finished-material',
        name: 'manufacture-semi-finished-material-index',
        component:  () => import('../pages/manufacture/SemiFinishedMaterialIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'material',
        name: 'manufacture-material-index',
        component:  () => import('../pages/manufacture/MaterialIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default manufactureRouter
