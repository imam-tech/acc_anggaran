import hasLoggedIn from "../middleware/hasLoggedIn";

const masterDataRouter = [
    {
        path: 'contact',
        name: 'master-data-contact-index',
        component:  () => import('../pages/masterData/contact/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'contact/:type/form',
        name: 'master-data-contact-form',
        component:  () => import('../pages/masterData/contact/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },{
        path: 'product/',
        name: 'master-data-product-index',
        component: () => import('../pages/masterData/product/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product/:type/form',
        name: 'master-data-product-form',
        component:  () => import('../pages/masterData/product/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product/:id/detail',
        name: 'master-data-product-detail',
        component:  () => import('../pages/masterData/product/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'product/category',
        name: 'master-data-product-category-index',
        component: () => import('../pages/masterData/product/CategoryIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'unit',
        name: 'master-data-unit-index',
        component: () => import('../pages/masterData/UnitIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'payment-method',
        name: 'master-data-payment-method-index',
        component: () => import('../pages/masterData/PaymentMethod'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'taxes',
        name: 'master-data-taxes-index',
        component: () => import('../pages/masterData/Taxes'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'coa',
        name: 'master-data-coa-index',
        component:  () => import('../pages/masterData/coa/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'coa/category',
        name: 'master-data-coa-category-index',
        component:  () => import('../pages/masterData/coa/CategoryIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'coa/:id/detail',
        name: 'master-data-coa-detail',
        component:  () => import('../pages/masterData/coa/Detail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'coa/category/:id/detail',
        name: 'master-data-coa-category-detail',
        component:  () => import('../pages/masterData/coa/CategoryDetail'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'tag',
        name: 'master-data-data-tag-index',
        component: () => import('../pages/masterData/TagIndex'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
];

export default masterDataRouter
