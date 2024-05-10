<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Report List</h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4" v-for="(reportMenu, index) in reportMenus" :key="index">
                        <div class="card mt-5">
                            <div class="card-body shadow-lg d-flex flex-column">
                                <h5 class="card-title">{{ reportMenu.label }}</h5>
                                <span>{{ reportMenu.description }}</span>
                                <router-link :to="reportMenu.link">
                                    <button type="button" class="btn btn-info mt-2">View Report</button>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                reportMenus: [
                    {
                        "label": "Balance Sheet",
                        "link": "/app/output-data/report/balance-sheet",
                        "description": "Lists what you own (assets), what your debts are (liabilities), and what you've invested in your company (equity)."
                    },
                    {
                        "label": "Cashflow",
                        "link": "/app/output-data/report/cashflow",
                        "description" : "This report measures the cash generated or used by a company and shows how it has moved in a given period."
                    },
                    {
                        "label": "Profit/Lose",
                        "link": "/app/output-data/report/profit-lose",
                        "description": "This report measures the cash generated or used by a company and shows how it has moved in a given period"
                    },
                    {
                        "label": "Journal",
                        "link": "/app/output-data/report/journal",
                        "description": "This report measures the cash generated or used by a company and shows how it has moved in a given period."
                    },
                    {
                        "label": "General Ledger",
                        "link": "/app/output-data/report/general-ledger",
                        "description" : "This report measures the cash generated or used by a company and shows how it has moved in a given period."
                    }
                ]
            }
        },
    }
</script>