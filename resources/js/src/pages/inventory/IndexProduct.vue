<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Product</h1>
                    <router-link to="/app/inventory/product/create/form">
                        <button type="button" class="btn btn-success float-right mr-3">
                            <i class="fa fa-plus-circle"></i> Create New Product
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th><b>Code/Sku</b></th>
                            <th><b>Product Name</b></th>
                            <th><b>Unit Name</b></th>
                            <th><b>Brand Name</b></th>
                            <th><b>Category Name</b></th>
                            <th><b>Stock</b></th>
                            <th class="text-right"><b>Purchase Rate</b></th>
                            <th class="text-right"><b>Sales Rate</b></th>
                            <th>#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="products.length == 0">
                            <td colspan="8" class="text-center">
                                Product Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in products" :key="pI">
                            <td>{{ p.id }}</td>
                            <td>{{ p.product_name }}</td>
                            <td>{{ p.unit }}</td>
                            <td>{{ p.brand }}</td>
                            <td>{{ p.category }}</td>
                            <td>{{ p.stock }}</td>
                            <td class="text-right">{{ p.purchase_price }}</td>
                            <td class="text-right">{{ p.selling_price }}</td>
                            <td>
                                <router-link :to="'product/' + p.id + '/form'">
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
                products: []
            }
        },
        created() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.products = await this.$axios.get(`api/product`)
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