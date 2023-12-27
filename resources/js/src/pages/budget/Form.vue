<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Budget Form</h1>
                <router-link to="/app/budget" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-xl-3">
                            <div class="form-group">
                                <label for="">Budget Name</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label for="">Start Period</label>
                                <input type="month" class="form-control">
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label for="">No Period</label>
                                <select class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-xl-2">
                            <div class="form-group">
                                <label for="">Previous Period</label>
                                <select class="form-control"></select>
                            </div>
                        </div>
                        <div class="col-xl-3 d-flex justify-content-end align-items-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Apply
                            </button>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <div class="row">
                        <div class="col-12 text-center d-flex flex-column">
                            <span>{{ currentCompany }}</span>
                            <span><b>Budget Management</b></span>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-6 p-0">
                                    <table class="table">
                                        <thead>
                                        <tr class="backgroup bg-light bg-gradient p-2 rounded">
                                            <th>Account</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="p-0">
                                                <table class="table table-borderless">
                                                    <tr v-for="(cl, iC) in coaList" :key="iC">
                                                        <td :class="cl.type2 === 'parent' ? 'font-weight-bold bg-light' : 'pl-4'">{{ cl.label }}</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfooter>
                                            <tr class="backgroup bg-light bg-gradient p-2 rounded">
                                                <th>Account</th>
                                            </tr>
                                        </tfooter>
                                    </table>
                                </div>
                                <div class="col-6 p-0">
                                    <table class="table table-bordered table-responsive">
                                        <thead>
                                        <tr class="bg-gray-300 p-2 rounded">
                                            <th v-for="(month, iM) in months" :key="iM" v-if="iM < lastMonth">{{ month }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td v-for="(dataR, iR) in dataReports" :key="iR" class="p-0">
                                                <table class="table table-bordered">
                                                    <tr v-for="(j, iJ) in dataR.data" :key="iJ">
                                                        <td :class="j.type === 'parent' ? 'bg-light' : ''">{{ j.balance | formatPriceWithDecimal}}</td>
                                                        <td :class="j.type === 'parent' ? 'bg-light' : ''">{{ j.percentage | formatPriceWithDecimal}}%</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr class="bg-gray-300 p-2 rounded">
                                            <th v-for="(month, iM) in months" :key="iM" v-if="iM < lastMonth">{{ month }}</th>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Cookies from 'js-cookie'

    export default {
        name:'Detail',
        data() {
            return {
                formData: {
                    supplier_name: "",
                    invoice_date: "",
                    due_date: "",
                    reference_number:"None",
                    products: [{
                        product: "Samsung",
                        quantity: 1,
                        unit: 'Pcs',
                        rate: 163,
                        discount: 0,
                        tax_amount: 0,
                        amount: 0
                    }],
                    description: ""
                },
                selectedProduct: "",
                currentCompany: Cookies.get('current_company_title_fat'),
                months: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                coaList: [],
                dataReports: [],
                lastMonth: 3,
            }
        },

        mounted() {
            this.initiateData()
        },
        methods: {
            initiateData() {
                for (let i = 1; i <= this.lastMonth; i++) {
                    this.getData(i < 10 ? "0" + i : i)
                }
            },
            async getData(month) {
                try {
                    this.$vs.loading()
                    const respData = (await this.$axios.get('api/journal/report/balance-profit?month=' + month + '&year=2023&type=profit_lose')).data
                    const balances = [];
                    respData.accounts.forEach((x) => {
                        let type = 'child';
                        if (x.is_summary) {
                            type = 'parent'
                        }
                        if (month == "01") {
                            let respCl = {}
                            let type2 = 'child';
                            if (x.is_summary) {
                                type2 = 'parent'
                            }
                            if (x.account_name !== null) {
                                respCl = {
                                    "type": '',
                                    "label" : x.account_code + "-" + x.account_name,
                                    "type2" : type2
                                }
                            } else {
                                respCl = {
                                    "type": 'bold',
                                    "label" :  x.name,
                                    "type2" : type2
                                }
                            }
                            this.coaList.push(respCl)
                        }
                        balances.push({balance: x.balance, type: type, percentage: x.percentage})
                    })
                    this.dataReports.push({
                        'month' : month,
                        'data' : balances
                    })
                    this.$vs.loading.close()
                } catch (e) {
                    this.$vs.loading.close()
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        }
    }
</script>
