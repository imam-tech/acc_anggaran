<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Purchase</h1>
                    <router-link to="/app/purchase/create/form">
                        <button type="button" class="btn btn-primary float-right mr-3">
                            <i class="fa fa-plus-circle"></i> Create New Purchase
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6 col-xl-4 mb-2" v-for="(rc, rcI) in resumeCharts" :key="rcI">
                        <div class="card">
                            <div class="card-body shadow-lg p-2">
                                <div class="d-flex justify-content-between">
                                    <span>{{ rc.label }}</span>
                                    <span class="bg-info rounded p-1 text-white">{{ rc.count }}</span>
                                </div>
                                <span class="align-content-center">
                                    Rp. {{ rc.sum | formatPrice }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-6 col-xl-3">
                        <div class="form-group">
                            <label>Status<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <select class="form-control" v-model="formFilter.status">
                                <option value="">All Status</option>
                                <option value="Paid">Paid</option>
                                <option value="Partial">Partial</option>
                                <option value="Open">Open</option>
                                <option value="Overdue">Overdue</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <!--<div class="form-group">-->
                            <!--<label>To Date<span style="-->
                                    <!--color: red;-->
                                    <!--font-weight: bold;-->
                                    <!--font-style: italic;-->
                                <!--">*) required</span></label>-->
                            <!--<input type="date" class="form-control" v-model="formFilter.to_date">-->
                        <!--</div>-->
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <!--<div class="form-group">-->
                            <!--<label>Invoice Number<span style="-->
                                    <!--color: red;-->
                                    <!--font-weight: bold;-->
                                    <!--font-style: italic;-->
                                <!--">*) required</span></label>-->
                            <!--<input type="text" class="form-control" v-model="formFilter.invoice_number">-->
                        <!--</div>-->
                    </div>
                    <div class="col-lg-6 col-xl-2">
                        <!--<div class="form-group">-->
                            <!--<label>Customer<span style="-->
                                    <!--color: red;-->
                                    <!--font-weight: bold;-->
                                    <!--font-style: italic;-->
                                <!--">*) required</span></label>-->
                            <!--<select class="form-control" v-model="formFilter.supplier">-->

                            <!--</select>-->
                        <!--</div>-->
                    </div>
                    <div class="col-lg-12 col-xl-1 d-flex align-items-center justify-content-end">
                        <button type="button" @click="handleGetData()" class="btn btn-success"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center"><b>Transaction Date</b></th>
                            <th class="text-center"><b>Transaction Number</b></th>
                            <th class="text-center"><b>Vendor</b></th>
                            <th class="text-center"><b>Due Date</b></th>
                            <th class="text-center"><b>Status</b></th>
                            <th class="text-center"><b>Balance Due</b></th>
                            <th class="text-center"><b>Total</b></th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="purchase.length == 0">
                            <td colspan="8" class="text-center">
                                Purchase Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(s, sI) in purchase" :key="sI">
                            <td>{{ s.transaction_date }}</td>
                            <td>
                                <router-link :to="'purchase/' + s.id + '/detail'">
                                    {{ s.transaction_number }}
                                </router-link>
                            </td>
                            <td>{{ s.contact.name }}</td>
                            <td>{{ s.due_date }}</td>
                            <td><span :class="handleStatus(s).class">{{ handleStatus(s).label }}</span></td>
                            <td class="text-right">{{ handleShowBalanceDue(s) | formatPrice }}</td>
                            <td class="text-right">{{ parseFloat(s.grand_total) | formatPrice }}</td>
                            <td class="text-right">
                                <router-link v-if="!s.paid_date" :to="'purchase/' + s.id + '/form'">
                                    <button type="button" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </router-link>
                                <router-link :to="'purchase/' + s.id + '/detail'">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="8" class="text-end">
                                <pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="handleGetData"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
                purchase: [],
                formFilter: {
                    status: "",
                },
                page: 1,
                totalData: 0,
                perPage: 0,
                resumeCharts: [{
                    label: 'Open Purchases',
                    count: 0,
                    sum: 0
                },{
                    label: 'Overdue Purchases',
                    count: 0,
                    sum: 0
                },{
                    label: 'Payment Sent Last 30 Days',
                    count: 0,
                    sum: 0
                }],
            }
        },
        created() {
            this.handleGetData()
        },
        methods: {
            handleShowBalanceDue(s) {
                if (parseFloat(s.payment_amount_total) >= parseFloat(s.grand_total)) {
                    return 0
                }
                return parseFloat(s.grand_total) - parseFloat(s.payment_amount_total);
            },

            handleStatus(s) {
                if (parseFloat(s.payment_amount_total) < parseFloat(s.grand_total)) {
                    const dateNow = (new Date()).toISOString().split('T')[0]
                    if (s.due_date < dateNow) {
                        return {
                            "class": 'badge badge-danger',
                            "label": 'Overdue'
                        }
                    } else {
                        if (parseFloat(s.payment_amount_total) === 0) {
                            return {
                                "class": 'badge badge-warning',
                                "label": 'Open'
                            }
                        } else {
                            return {
                                "class": 'badge badge-warning',
                                "label": 'Partial'
                            }
                        }
                    }
                } else {
                    return {
                        "class": 'badge badge-success',
                        "label": 'Paid'
                    }
                }
            },

            async handleGetData() {
                try {
                    this.$vs.loading()
                    const purchaseLocal = await this.$axios.get(`api/purchase?page=${this.page}&` + new URLSearchParams(this.formFilter).toString())
                    this.purchase = purchaseLocal.data
                    this.totalData = purchaseLocal.total
                    this.page = purchaseLocal.current_page
                    this.perPage = purchaseLocal.per_page

                    const respSum = await this.$axios.get(`api/purchase/summarize-count`)
                    this.resumeCharts[0].count = respSum.data.open_invoice.total
                    this.resumeCharts[0].sum = respSum.data.open_invoice.amount
                    this.resumeCharts[1].count = respSum.data.overdue_invoice.total
                    this.resumeCharts[1].sum = respSum.data.overdue_invoice.amount
                    this.resumeCharts[2].count = respSum.data.payment_last_month.total
                    this.resumeCharts[2].sum = respSum.data.payment_last_month.amount
                    this.$vs.loading.close()
                } catch (e) {
                    this.$vs.loading.close()
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 2500
                    })
                }
            },
        }
    }
</script>