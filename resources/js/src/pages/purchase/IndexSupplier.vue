<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Supplier</h1>
                    <router-link to="/app/purchase/suppliers/create/form">
                        <button type="button" class="btn btn-success float-right mr-3">
                            <i class="fa fa-plus-circle"></i> Create New Supplier
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><b>Name</b></th>
                            <th><b>Email</b></th>
                            <th><b>Phone</b></th>
                            <th><b>Identity Number</b></th>
                            <th><b>NPWP Number</b></th>
                            <th><b>Address</b></th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="suppliers.length == 0">
                            <td colspan="7" class="text-center">
                                Supplier Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(c, cI) in suppliers" :key="cI">
                            <td>{{ c.name }}</td>
                            <td>{{ c.email }}</td>
                            <td>{{ c.phone }}</td>
                            <td>{{ c.identity_number }}</td>
                            <td>{{ c.npwp_number }}</td>
                            <td>{{ c.address }}</td>
                            <td>
                                <router-link :to="'suppliers/' + c.id + '/form'">
                                    <button class="btn btn-success" type="button">
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
                suppliers: []
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.suppliers = await this.$axios.get(`api/purchase/supplier`)
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