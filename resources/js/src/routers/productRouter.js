import hasLoggedIn from "../middleware/hasLoggedIn";

const productRouter = [
    {
        path: '',
        name: 'product-index',
        component: () => import('../pages/product/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'product-form',
        component:  () => import('../pages/product/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'category',
        name: 'product-category-index',
        component: () => import('../pages/product/CategoryIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'unit',
        name: 'product-unit-index',
        component: () => import('../pages/product/UnitIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default productRouter
