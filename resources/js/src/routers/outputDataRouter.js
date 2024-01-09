import hasLoggedIn from "../middleware/hasLoggedIn";

const outputDataRouter = [
    {
        path: 'report',
        name: 'output-data-index',
        component:  () => import('../pages/outputData/report/Index'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'report/balance-sheet',
        name: 'output-data-balance-sheet',
        component:  () => import('../pages/outputData/report/BalanceSheet'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'report/profit-lose',
        name: 'output-data-profit-lose',
        component:  () => import('../pages/outputData/report/ProfitLose'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'report/cashflow',
        name: 'output-data-cashflow',
        component:  () => import('../pages/outputData/report/Cashflow'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'report/journal',
        name: 'output-data-report-journal',
        component:  () => import('../pages/outputData/report/Journal'),
        meta: {
            middleware: hasLoggedIn,
        },
    },
    {
        path: 'report/general-ledger',
        name: 'output-data-report-general-ledger',
        component:  () => import('../pages/outputData/report/GeneralLedger'),
        meta: {
            middleware: hasLoggedIn,
        },
    }
];

export default outputDataRouter
