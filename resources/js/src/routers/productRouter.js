import hasLoggedIn from "../middleware/hasLoggedIn";

const productRouter = [
    {
        path: '',
        name: 'sales-and-purchase-product-index',
        component: () => import('../pages/product/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'sales-and-purchase-product-form',
        component:  () => import('../pages/product/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':id/detail',
        name: 'sales-and-purchase-product-detail',
        component:  () => import('../pages/product/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'category',
        name: 'other-list-product-category-index',
        component: () => import('../pages/product/CategoryIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'unit',
        name: 'other-list-product-unit-index',
        component: () => import('../pages/product/UnitIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default productRouter
