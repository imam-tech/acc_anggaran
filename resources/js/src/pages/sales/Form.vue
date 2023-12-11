<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Sales Form</h1>
                <router-link to="/app/sales" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>#Invoice Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" value="DRAFT" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Customer Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <div class="d-flex justify-content-between">
                                    <select class="form-control" v-model="formData.customer_name">
                                        <option value="">--Choose--</option>
                                        <option v-for="(c, cI) in customers" :value="c.id">{{ c.name }}</option>
                                    </select>
                                    <button class="btn btn-warning ml-2" type="button">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Invoice date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="date" class="form-control" v-model="formData.invoice_date">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Due date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="date" class="form-control" v-model="formData.due_date">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Product Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select class="form-control" v-model="selectedProduct" @change="handleChangeProduct">
                                    <option value=""></option>
                                    <option v-for="(c, cI) in products" :value="cI" :key="cI">{{ c.product_name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product/Service</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Rate</th>
                                    <th>Amount</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(fp, fpI) in formData.products" :key="fpI">
                                    <td>{{ fp.product }}</td>
                                    <td>
                                        <input type="number" class="form-control" v-model="formData.products[fpI].quantity" @keyup="handleChange()">
                                    </td>
                                    <td>{{ fp.unit }}</td>
                                    <td>
                                        <input type="number" class="form-control" v-model="formData.products[fpI].rate" @keyup="handleChange()">
                                    </td>
                                    <td>{{ fp.amount }}</td>
                                    <td>
                                        <button class="btn btn-danger" @click="handleDeleteProduct(fpI)" type="button">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label>Description<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <textarea v-model="formData.description" class="form-control" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <table class="table">
                                <tr>
                                    <td>Grand Total</td>
                                    <td>
                                        <input type="text" class="form-control" :value="grandTotal">
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        name:'Detail',
        data() {
            return {
                formData: {
                    customer_name: "",
                    invoice_date: "",
                    due_date: "",
                    products: [],
                    description: ""
                },
                selectedProduct: "",
                customers: [],
                products: [],
                grandTotal: 0
            }
        },

        mounted() {
            this.getDataOther()
        },
        methods: {
            handleChange() {
                let grandTotal = 0
                const prods = this.formData.products
                prods.forEach((x, i) => {
                    this.formData.products[i].amount = x.quantity * x.rate
                    grandTotal = grandTotal + this.formData.products[i].amount
                })
                this.grandTotal = grandTotal
            },
            handleDeleteProduct(index) {
                this.formData.products = this.formData.products.filter((item, ind) => ind !== index)
                this.handleChange()
            },
            handleChangeProduct(e) {
                const prod = this.products[e.target.value]
                this.formData.products.push({
                    product: prod.product_name,
                    quantity: 1,
                    unit: prod.unit,
                    rate: prod.selling_price,
                    amount: prod.selling_price
                })
                this.handleChange()
            },
            async getDataOther() {
                try {
                    this.$vs.loading()
                    this.customers = await this.$axios.get(`api/sales/customer`)
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
