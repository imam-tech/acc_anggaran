import hasLoggedIn from "../middleware/hasLoggedIn";

const inventoryRouter = [
    {
        path: 'product',
        name: 'inventory-product-index',
        component: () => import('../pages/inventory/IndexProduct'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product/:type/form',
        name: 'inventory-product-form',
        component:  () => import('../pages/inventory/FormProduct'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product-category',
        name: 'inventory-product-category',
        component: () => import('../pages/inventory/IndexProductCategory'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product-brand',
        name: 'inventory-product-brand',
        component: () => import('../pages/inventory/IndexProductBrand'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'unit',
        name: 'inventory-unit',
        component: () => import('../pages/inventory/IndexUnit'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default inventoryRouter
