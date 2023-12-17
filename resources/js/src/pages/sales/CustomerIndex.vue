<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Customer</h1>
                    <router-link to="/app/sales/customer/create/form">
                        <button type="button" class="btn btn-primary float-right mr-3">
                            <i class="fa fa-plus-circle"></i> Create New Customer
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center"><b>Name</b></th>
                            <th class="text-center"><b>Email</b></th>
                            <th class="text-center"><b>Phone</b></th>
                            <th class="text-center"><b>Identity Number</b></th>
                            <th class="text-center"><b>NPWP Number</b></th>
                            <th class="text-center"><b>Address</b></th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="customers.length == 0">
                            <td colspan="7" class="text-center">
                                Customer Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(c, cI) in customers" :key="cI">
                            <td>{{ c.name }}</td>
                            <td>{{ c.email }}</td>
                            <td>{{ c.phone }}</td>
                            <td>{{ c.identity_number }}</td>
                            <td>{{ c.npwp_number }}</td>
                            <td>{{ c.address }}</td>
                            <td class="text-right">

                                <router-link :to="'customer/' + c.id + '/form'">
                                    <button class="btn btn-warning" type="button">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </router-link>
                                <button class="btn btn-danger" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
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
                customers: []
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.customers = await this.$axios.get(`api/sales/customer`)
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