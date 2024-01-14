<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <div class="mt-3 d-flex justify-content-between">
                    <h1 class="h3 ml-3 text-gray-800 float-left">Product</h1>
                    <router-link to="/app/master-data/product/create/form">
                        <button type="button" class="btn btn-primary float-right mr-3">
                            <i class="fas fa-plus-circle"></i> Create New Product
                        </button>
                    </router-link>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center"><b>SKU Code</b></th>
                            <th class="text-center"><b>Name</b></th>
                            <th class="text-center"><b>Unit Name</b></th>
                            <th class="text-center"><b>Category Name</b></th>
                            <th class="text-center"><b>Show on Sales</b></th>
                            <th class="text-center"><b>Show on Purchase</b></th>
                            <th class="text-center"><b>Sales Price</b></th>
                            <th class="text-center"><b>Purchase Price</b></th>
                            <th class="text-center"><b>Is Archived?</b></th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="products.length == 0">
                            <td colspan="10" class="text-center">
                                Product Not Found
                            </td>
                        </tr>
                        <tr v-else v-for="(p, pI) in products" :key="pI">
                            <td>{{ p.sku_code ?? '-' }}</td>
                            <td>{{ p.name }}</td>
                            <td>{{ p.unit ? p.unit.name : '-' }}</td>
                            <td>{{ p.category ? p.category.name : '-' }}</td>
                            <td class="text-center">
                                <span v-if="p.is_sale" class="badge badge-primary">Yes</span>
                                <span v-else class="badge badge-warning">No</span>
                            <td class="text-center">
                                <span v-if="p.is_purchase" class="badge badge-primary">Yes</span>
                                <span v-else class="badge badge-warning">No</span>
                            </td>
                            <td class="text-right">{{ p.unit_sale_price | formatPrice}}</td>
                            <td class="text-right">{{ p.unit_purchase_price | formatPrice }}</td>
                            <td class="text-center">
                                <span v-if="p.is_archive" class="badge badge-danger p-3">Yes</span>
                                <span v-else class="badge badge-primary p-3">No</span>
                            </td>
                            <td class="text-right">
                                <router-link :to="'product/' + p.id + '/detail'">
                                    <button class="btn btn-primary" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </router-link>
                                <router-link :to="'product/' + p.id + '/form'">
                                    <button class="btn btn-warning" type="button">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </router-link>
                                <button v-if="p.sale_product === null && p.purchase_product" @click="handleDelete(p.id)" class="btn btn-danger" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <button v-else @click="handleArchive(p)" class="btn btn-secondary" type="button">
                                    <i class="fas fa-archive"></i>
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
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading()
                    this.products = await this.$axios.get(`api/master-data/product`)
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

            async handleDelete(id) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Are You Sure Want To Delete This Product?',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.delete(`api/master-data/product/${id}/delete`).then((response)=>{
                            this.$vs.loading.close()
                            if(response.status){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false
                                }).then(async (res)=>{
                                    if(res.isConfirmed == true) await this.handleGetData()
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: "Opps...",
                                    text: "Failed To Delete Product : " + response.message ,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                });
                            }
                        });
                    }
                })
            },

            async handleArchive(p) {
                Swal.fire({
                    icon: 'warning',
                    title: `Are You Sure Want To ${p.is_archive ? 'Un Archive' : 'Archive'} This Product?`,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showCloseButton: true,
                    showCancelButton: true,
                }).then((result)=>{
                    if(result.isConfirmed == true){
                        this.$vs.loading()
                        this.$axios.get(`api/master-data/product/${p.id}/archive`).then((response)=>{
                            this.$vs.loading.close()
                            if(response.status){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false
                                }).then(async (res)=>{
                                    if(res.isConfirmed == true) await this.handleGetData()
                                })
                            }else{
                                Swal.fire({
                                    icon: "error",
                                    title: "Opps...",
                                    text: "Failed To Archive Product : " + response.message ,
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                });
                            }
                        });
                    }
                })
            }
        }
    }
</script>