<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Purchase Bill Form</h1>
                <router-link to="/app/purchase" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="handleSubmit()">
                    <div class="row">
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>#Bill Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" value="DRAFT" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Supplier Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <div class="d-flex justify-content-between">
                                    <v-select v-model="formData.supplier" :options="suppliers" :reduce="supplier => supplier.id" label="name" style="width: 100%">
                                        <span slot="no-options">Supplier not found, use + to add</span>
                                    </v-select>

                                    <button class="btn btn-warning ml-2" type="button" @click="handleShowAddModalSupplier()">
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
                                <input type="date" class="form-control" v-model="formData.invoice_date" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Due date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="date" class="form-control" v-model="formData.due_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="form-group">
                                <label>Type<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select class="form-control" v-model="formData.type" @change="handleChangeType" required>
                                    <option value="">--Choose Type--</option>
                                    <option value="Material">Material</option>
                                    <option value="Product">Product</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-8">
                            <div class="form-group">
                                <label>{{ formData.type }} Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <div class="d-flex justify-content-between">
                                    <v-select v-model="selectedProduct" :options="products" :reduce="p => p" style="width: 100%" label="label" @input="handleChangeProduct">
                                        <span slot="no-options">{{ formData.type === '' ? "Please Select Type First" : "Product not found, use + to add" }}</span>
                                    </v-select>
                                    <button v-if="formData.type !== ''" @click="handleShowAddNewMaterial()" class="btn btn-warning ml-2" type="button">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product/Material</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Price/Unit</th>
                                    <th>Amount Total</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(fp, fpI) in formData.products" :key="fpI">
                                    <td>{{ fp.name }}</td>
                                    <td>
                                        <input type="number" class="form-control" v-model="formData.products[fpI].quantity" @keyup="handleChange()" required>
                                    </td>
                                    <td>{{ fp.unit }}</td>
                                    <td>
                                        <input type="number" class="form-control" v-model="formData.products[fpI].amount_per_unit" @keyup="handleChange()" required>
                                    </td>
                                    <td>{{ fp.amount_total }}</td>
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
                                <label>Description</label>
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
            <div class="modal fade" id="addNewMaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="handleSubmitAddNew">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New a {{ formData.type }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>{{ formData.type }} Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                    <input type="text" class="form-control" v-model="formAdd.name" required>
                                </div>
                                <div class="form-group">
                                    <label>Image<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                    <input type="file" class="form-control">
                                </div>
                                <img :src="formAdd.image" width="100" alt="" class="rounded">
                                <div class="form-group">
                                    <label>Unit<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                    <div class="d-flex justify-content-between">
                                        <select v-model="formAdd.unit" class="form-control">
                                            <option v-for="(u, uI) in units" :key="uI" :value="u.title">{{ u.title }}</option>
                                        </select>
                                        <button @click="handleShowAddNewUnit()" class="btn btn-warning ml-2" type="button">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addNewUnit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="handleSubmitAddNewUnit">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Unit</h5>
                                <button @click="handleCancelShowUnit()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Unit Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                    <input type="text" class="form-control" v-model="titleUnit" required>
                                </div>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-secondary" @click="handleCancelShowUnit()">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addNewSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="handleSubmitAddNewSupplier">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Supplier</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                    <input type="text" class="form-control" v-model="formAddSupplier.name" required>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Phone<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                    <input type="text" class="form-control" v-model="formAddSupplier.phone" required>
                                </div>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
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
                formAddSupplier: {
                    id: "",
                    name: "",
                    phone: ""
                },
                formData: {
                    supplier: "",
                    invoice_date: "",
                    due_date: "",
                    type: "",
                    products: [],
                    description: ""
                },
                selectedProduct: "",
                products: [],
                formAdd: {
                    id: "",
                    name: "",
                    image: "https://stage-accounting.sgp1.cdn.digitaloceanspaces.com/fat/product/JnydOoMDv3Sql3DE2MKyWuugLvGqS2ZZBP7LXNUL.png",
                    unit: "",
                    stock: 0
                },
                units: [],
                titleUnit: "",
                grandTotal: 0,
                suppliers: []
            }
        },

        mounted() {
            this.handleGetSupplier()
        },
        methods: {
            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/purchase`, this.formData)
                    this.$vs.loading.close()
                    if (!resp.status)  {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    } else {

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

            async handleGetSupplier() {
                try {
                    if (this.units.length === 0) {
                        this.$vs.loading()
                        this.suppliers = await this.$axios.get(`api/purchase/supplier`)
                        this.$vs.loading.close()
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
                }},

            handleShowAddModalSupplier() {
                $("#addNewSupplier").modal('show')
            },

            handleChange() {
                let grandTotal = 0
                const prods = this.formData.products
                prods.forEach((x, i) => {
                    this.formData.products[i].amount_total = x.quantity * x.amount_per_unit
                    grandTotal = grandTotal + this.formData.products[i].amount_total
                })
                this.grandTotal = grandTotal
            },

            handleCancelShowUnit() {
                $("#addNewMaterial").modal("show")
                $("#addNewUnit").modal("hide")
            },

            handleShowAddNewUnit() {
                $("#addNewMaterial").modal("hide")
                $("#addNewUnit").modal("show")
            },

            async handleSubmitAddNewSupplier() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/purchase/supplier`, this.formAddSupplier)
                    this.$vs.loading.close()
                    if (!resp.status)  {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    } else {
                        await this.handleGetSupplier()
                        $("#addNewSupplier").modal("hide")
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

            async handleSubmitAddNewUnit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/product/unit`, {
                        id: "",
                        title: this.titleUnit
                    })
                    this.$vs.loading.close()
                    if (!resp.status)  {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    } else {
                        this.units = []
                        await this.handleGetUnit()
                        $("#addNewMaterial").modal("show")
                        $("#addNewUnit").modal("hide")
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

            async handleSubmitAddNew() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/manufacture/material`, this.formAdd)
                    this.$vs.loading.close()
                    if (!resp.status)  {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    } else {
                        $("#addNewMaterial").modal('hide')
                        this.handleChangeType()
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

            handleDeleteProduct(index) {
                this.formData.products = this.formData.products.filter((item, ind) => ind !== index)
                this.handleChange()
            },

            async handleShowAddNewMaterial() {
                await this.handleGetUnit()
                $("#addNewMaterial").modal("show")
            },

            async handleChangeProduct(val) {
                const selectProd = val.value
                if (this.selectedProduct !== ''){
                    this.formData.products.push({
                        id: selectProd.id,
                        type: this.formData.type,
                        name: selectProd.name,
                        quantity: 1,
                        unit: selectProd.unit,
                        amount_per_unit: 0,
                        amount_total: 0
                    })
                }
            },

            async handleChangeType() {
                try {
                    this.$vs.loading()
                    this.selectedProduct = ""
                    this.products = [];
                    const prodLocals = await this.$axios.get(`api/purchase/get-product-material/${this.formData.type}`)
                    prodLocals.forEach((x) => {
                        this.products.push({id: x.id, label: x.name + ' (' + x.unit + ')', value: x })
                    })
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

            async handleGetUnit() {
                try {
                    if (this.units.length === 0) {
                        this.$vs.loading()
                        this.units = await this.$axios.get(`api/product/unit`)
                        this.$vs.loading.close()
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
            }
        },
    }
</script>
