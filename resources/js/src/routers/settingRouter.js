import hasLoggedIn from "../middleware/hasLoggedIn";

const settingRouter = [
    {
        path: '',
        name: 'setting-index',
        component:  () => import('../pages/setting/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default settingRouter
