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
                        <button type="button" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><b>Supplier Name | Phone</b></th>
                            <th><b>Bill Number</b></th>
                            <th><b>Invoice Date</b></th>
                            <th><b>Due Date</b></th>
                            <th class="text-right"><b>Total</b></th>
                            <th class="text-right">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="purchases.length == 0">
                            <td colspan="6" class="text-center">
                                Purchase Bill Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in purchases" :key="pI">
                            <td>{{ p.supplier.name }} | {{ p.supplier.phone }}</td>
                            <td>{{ p.bill_number }}</td>
                            <td>{{ p.invoice_date }}</td>
                            <td>{{ p.due_date }}</td>
                            <td class="text-right">{{ p.amount_total | formatPrice }}</td>
                            <td class="text-right">
                                <button type="button" :disabled="p.bill_number !== 'DRAFT'" class="btn btn-warning">
                                    <router-link :to="'/app/purchase/'+p.id+'/form'">
                                        <i class="fas fa-pencil-alt"></i>
                                    </router-link>
                                </button>
                                <router-link :to="'/app/purchase/'+p.id+'/detail'">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </router-link>
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
                purchases: [],
                formFilter: {
                    from_date: "",
                    to_date: "",
                    bill_number: "",
                    supplier: ""
                }
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.purchases = await this.$axios.get(`api/purchase`)
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
            },
        }
    }
</script>