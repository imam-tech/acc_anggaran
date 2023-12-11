<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Accounts</h1>
                    <router-link to="/app/sales/create/form">
                        <button type="button" class="btn btn-success float-right mr-3">
                            <i class="fa fa-plus-circle"></i> Create New Sales
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-lg-6 col-xl-3">
                        <div class="form-group">
                            <label>From Date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <input type="date" class="form-control" v-model="formFilter.from_date">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="form-group">
                            <label>To Date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <input type="date" class="form-control" v-model="formFilter.to_date">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-3">
                        <div class="form-group">
                            <label>Invoice Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <input type="text" class="form-control" v-model="formFilter.invoice_number">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-2">
                        <div class="form-group">
                            <label>Customer<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <select class="form-control" v-model="formFilter.customer">

                            </select>
                        </div>
                    </div>
                    <div class="col-lg-12 col-xl-1 d-flex align-items-center justify-content-end">
                        <button type="button" class="btn btn-warning"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><b>Customer Name</b></th>
                            <th><b>Invoice Number</b></th>
                            <th><b>Date</b></th>
                            <th class="text-right"><b>Total</b></th>
                            <th><b>Status</b></th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="sales.length == 0">
                            <td colspan="6" class="text-center">
                                Sales Not Founnd
                            </td>
                        </tr>
                        <tr v-else v-for="(s, sI) in sales" :key="sI">
                            <td>{{ s.customer_name }}</td>
                            <td>{{ s.invoice_number }}</td>
                            <td>{{ s.date }}</td>
                            <td class="text-right">{{ s.total }}</td>
                            <td>{{ s.status }}</td>
                            <td></td>
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
                sales: [{
                    "customer_name": "Budi",
                    "invoice_number": "DRAFT",
                    "date": "2023-01-02",
                    "total": 1980,
                    "status" : "DRAFT"
                },{
                    "customer_name": "hartono",
                    "invoice_number": "SalInvP217SalInvS",
                    "date": "2023-01-02",
                    "total": 1980,
                    "status" : "DRAFT"
                }],
                formFilter: {
                    from_date: "",
                    to_date: "",
                    invoice_number: "",
                    customer: ""
                }
            }
        },
        created() {
        },
    }
</script>