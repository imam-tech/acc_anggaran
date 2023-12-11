import hasLoggedIn from "../middleware/hasLoggedIn";

const cashAndBankRouter = [
    {
        path: '',
        name: 'cash-and-bank-index',
        component:  () => import('../pages/cashAndBank/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: ':type/form',
        name: 'cash-and-bank-form',
        component:  () => import('../pages/cashAndBank/Form'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default cashAndBankRouter
