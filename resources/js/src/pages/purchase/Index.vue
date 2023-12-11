<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Purchase Bill</h1>
                    <router-link to="/app/purchase/create/form">
                        <button type="button" class="btn btn-success float-right mr-3">
                            <i class="fa fa-plus-circle"></i> Create New Purchase Bill
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
                            <label>Bill Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <input type="text" class="form-control" v-model="formFilter.bill_number">
                        </div>
                    </div>
                    <div class="col-lg-6 col-xl-2">
                        <div class="form-group">
                            <label>Supplier<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                            <select class="form-control" v-model="formFilter.supplier">

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
                            <th><b>Supplier Name</b></th>
                            <th><b>Bill Number</b></th>
                            <th><b>Date</b></th>
                            <th class="text-right"><b>Total</b></th>
                            <th><b>Status</b></th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="purchases.length == 0">
                            <td colspan="6" class="text-center">
                                Purchase Bill Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in purchases" :key="pI">
                            <td>{{ p.supplier_name }}</td>
                            <td>{{ p.bill_number }}</td>
                            <td>{{ p.date }}</td>
                            <td class="text-right">{{ p.total }}</td>
                            <td>{{ p.status }}</td>
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
                purchases: [{
                    "supplier_name": "Budi",
                    "bill_number": "DRAFT",
                    "date": "2023-01-02",
                    "total": 1980,
                    "status" : "DRAFT"
                },{
                    "supplier_name": "hartono",
                    "bill_number": "SalInvP217SalInvS",
                    "date": "2023-01-02",
                    "total": 1980,
                    "status" : "DRAFT"
                }],
                formFilter: {
                    from_date: "",
                    to_date: "",
                    bill_number: "",
                    supplier: ""
                }
            }
        },
        created() {
        },
    }
</script>