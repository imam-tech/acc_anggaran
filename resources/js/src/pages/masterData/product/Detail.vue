<template>
    <div v-if="productData" class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Product Detail</h1>
                <router-link to="/app/master-data/product" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th colspan="2" class="text-center"><i class="fas fa-box"></i> Information</th>
                            </tr>
                            <tr>
                                <th>Name</th>
                                <td>{{productData.name}}</td>
                            </tr>
                            <tr>
                                <th>Category</th>
                                <td>{{productData.category ? productData.category.name : '-'}}</td>
                            </tr>
                            <tr>
                                <th>Unit</th>
                                <td>{{productData.unit ? productData.unit.name : '-'}}</td>
                            </tr>
                            <tr>
                                <th>Sku Code</th>
                                <td>{{productData.sku_code}}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{productData.description}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xl-4">
                        <table v-if="productData.is_sale" class="table table-striped mb-5">
                            <tbody>
                            <tr>
                                <th colspan="2" class="text-center"><i class="fas fa-cart-plus"></i> Sales</th>
                            </tr>
                            <tr>
                                <th>Unit Price Sell</th>
                                <td>{{productData.unit_sale_price | formatPrice}}</td>
                            </tr>
                            <tr>
                                <th>Sell Account</th>
                                <td>{{productData.sale_coa ? productData.sale_coa.account_code : '-'}}</td>
                            </tr>
                            <tr>
                                <th>Sell Tax</th>
                                <td>{{productData.sale_tax ? productData.sale_tax.name : '-'}}</td>
                            </tr>
                            </tbody>
                        </table>

                        <table v-if="productData.is_purchase" class="table table-striped">
                            <tbody>
                            <tr>
                                <th colspan="2" class="text-center"><i class="fas fa-clipboard-list"></i> Purchase</th>
                            </tr>
                            <tr>
                                <th>Unit Price Buy</th>
                                <td>{{productData.unit_purchase_price | formatPrice}}</td>
                            </tr>
                            <tr>
                                <th>Buy Account</th>
                                <td>{{productData.purchase_coa ? productData.purchase_coa.account_code : '-'}}</td>
                            </tr>
                            <tr>
                                <th>Buy Tax</th>
                                <td>{{productData.purchase_tax ? productData.purchase_tax.name : '-'}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <table v-if="productData.is_sale" class="table table-striped mb-5">
                            <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(sp, spI)  in productData.sale_products" :key="spI">
                                <td>{{ sp.sales.transaction_date }}</td>
                                <td>
                                    <router-link :to="`/app/sales/${sp.sales.id}/detail`">{{ sp.sales.transaction_number }}</router-link>
                                </td>
                                <td>{{ sp.quantity }} {{ sp.unit }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table v-if="productData.is_purchase" class="table table-striped mb-5">
                            <thead>
                            <tr>
                                <th class="text-center">Date</th>
                                <th class="text-center">Tipe</th>
                                <th class="text-center">Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(sp, spI)  in productData.purchase_products" :key="spI">
                                <td>{{ sp.purchase.transaction_date }}</td>
                                <td>
                                    <router-link :to="`/app/purchase/${sp.purchase.id}/detail`">{{ sp.purchase.transaction_number }}</router-link>
                                </td>
                                <td>{{ sp.quantity }} {{ sp.unit }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name:'Detail',
        data() {
            return {
                productData: ''
            }
        },

        mounted() {
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    const respDe = await this.$axios.get(`api/master-data/product/${this.$route.params.id}/detail`)
                    this.$vs.loading.close()

                    if (!respDe.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respDe.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        this.productData = respDe.data
                    }
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
