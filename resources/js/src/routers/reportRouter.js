import hasLoggedIn from "../middleware/hasLoggedIn";

const reportRouter = [
    {
        path: '',
        name: 'accounting-report-index',
        component:  () => import('../pages/report/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'balance-sheet',
        name: 'accounting-report-balance-sheet',
        component:  () => import('../pages/report/BalanceSheet'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'profit-lose',
        name: 'accounting-report-profit-lose',
        component:  () => import('../pages/report/ProfitLose'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'cashflow',
        name: 'accounting-report-cashflow',
        component:  () => import('../pages/report/Cashflow'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'journal',
        name: 'report-journal',
        component:  () => import('../pages/report/Journal'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'general-ledger',
        name: 'report-general-ledger',
        component:  () => import('../pages/report/GeneralLedger'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default reportRouter
