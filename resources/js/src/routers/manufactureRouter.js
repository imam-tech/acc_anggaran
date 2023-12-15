import hasLoggedIn from "../middleware/hasLoggedIn";

const manufactureRouter = [
    {
        path: 'product',
        name: 'manufacture-product-index',
        component:  () => import('../pages/manufacture/IndexProduct'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product/:type/form',
        name: 'manufacture-product-form',
        component:  () => import('../pages/manufacture/FormProduct'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product/:type/detail',
        name: 'manufacture-product-detail',
        component:  () => import('../pages/manufacture/DetailProduct'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'semi-finished-material',
        name: 'manufacture-semi-finished-material-index',
        component:  () => import('../pages/manufacture/IndexSemiFinishedMaterial'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'material',
        name: 'manufacture-material-index',
        component:  () => import('../pages/manufacture/IndexMaterial'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default manufactureRouter
