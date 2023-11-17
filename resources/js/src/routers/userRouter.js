import hasLoggedIn from "../middleware/hasLoggedIn";

const userRouter = [
    {
        path: '',
        name: 'user-index',
        component:  () => import('../pages/user/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default userRouter
