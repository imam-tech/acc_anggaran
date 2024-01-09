<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Finished Goods Form</h1>
                <router-link to="/app/manufacture/product" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="handleSubmit()">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>#Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" value="DRAFT" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.name" placeholder="Example: Cake" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Semi Finished Goods Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <div class="d-flex justify-content-between">
                                    <v-select v-model="selectedProduct" :options="products" :reduce="p => p" style="width: 100%" label="label" @input="handleChangeProduct">
                                        <span slot="no-options">{{ formData.type === '' ? "Please Select Type First" : "Product not found, use + to add" }}</span>
                                    </v-select>
                                    <button @click="handleShowAddNewMaterial()" class="btn btn-warning ml-2" type="button">
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
                                    <th>Semi Finished Goods Name</th>
                                    <th>Items</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(fp, fpI) in formData.products" :key="fpI">
                                    <td>{{ fp.name }}</td>
                                    <td>
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th class="text-center"><b>MaterialName</b></th>
                                                <th class="text-center"><b>Price per Unit</b></th>
                                                <th></th>
                                                <th class="text-center"><b>Dose</b></th>
                                                <th class="text-center"><b>Dose Price</b></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(item, itemI) in fp.items" :key="itemI">
                                                <td>{{ item.material.name }}</td>
                                                <td class="text-right">{{ item.material.price_per_unit | formatPrice }} </td>
                                                <td>/ {{ item.material.unit }}</td>
                                                <td class="text-right">{{ item.dose }}</td>
                                                <td class="text-right">{{ (item.dose * item.material.price_per_unit) | formatPrice}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
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
            <SemiFinishedMaterialCrud :get-data="handleChangeType" :materials="materials" :form-data="formAdd" :label-modal="labelModal"></SemiFinishedMaterialCrud>
        </div>
    </div>
</template>

<script>
    import SemiFinishedMaterialCrud from './components/SemiFinishedMaterialCrud'

    export default {
        name:'Detail',
        components: {SemiFinishedMaterialCrud},
        data() {
            return {
                materials: [],
                selectedMaterial: '',

                formAddSupplier: {
                    id: "",
                    name: "",
                    phone: ""
                },
                formData: {
                    id: "",
                    name: "",
                    type: "",
                    products: [],
                    description: ""
                },
                selectedProduct: "",
                products: [],
                formAdd: {
                    id: "",
                    name: "",
                    items: []
                },
                titleUnit: "",
                grandTotal: 0,
                suppliers: []
            }
        },

        mounted() {
            if (this.$route.params.type !== 'create') {
                this.handleGet()
            }
            this.handleChangeType()
        },
        methods: {
            async handleChangeProduct(val) {
                const selectProd = val.value
                if (this.selectedProduct !== ''){
                    this.formData.products.push({
                        id: selectProd.id,
                        name: selectProd.name,
                        items: selectProd.items
                    })
                    this.handleChange()
                }
            },

            async handleChangeType() {
                try {
                    this.$vs.loading()
                    this.selectedProduct = ""
                    this.products = [];
                    const prodLocals = await this.$axios.get(`api/manufacture/get-semi-finished-material`)
                    prodLocals.forEach((x) => {
                        this.products.push({id: x.id, label: x.name, value: x })
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

            async handleGetMaterial() {
                try {
                    if (this.materials.length === 0) {
                        this.$vs.loading()
                        this.materials = await this.$axios.get(`api/manufacture/material?is_archive=no`)
                        this.$vs.loading.close()
                    }
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

            async handleShowAddNewMaterial() {
                console.log("oke")
                await this.handleGetMaterial()
                this.labelModal = "Add"
                this.formAdd = {
                    id: "",
                    name: "",
                    items: []
                }
                $("#addNewMaterial").modal("show")
            },

            handleChangeMaterial() {
                let isInsert = false;
                this.formAdd.items.forEach((x) => {
                    if (x.id === this.selectedMaterial.id) {
                        isInsert = true
                    }
                })

                if (!isInsert) {
                    let selM = this.selectedMaterial
                    selM.dose = 0;
                    this.selectedMaterial = selM
                    this.formAdd.items.push(this.selectedMaterial)
                    console.log("sele", this.selectedMaterial)
                }
            },

            async handleSubmitAddNew() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/manufacture/semi-finished-material`, this.formAdd)
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

            handleChange() {
                console.log("oke")
                let grandTotal = 0
                const prods = this.formData.products
                prods.forEach((x, i) => {
                    let amountTotal = 0;
                    x.items.forEach((it) => {
                        amountTotal = amountTotal + (it.dose * it.material.price_per_unit)
                    })
                    this.formData.products[i].amount_total = amountTotal
                    grandTotal = grandTotal + this.formData.products[i].amount_total
                })
                this.grandTotal = grandTotal
            },

            async handleGet() {
                try {
                    this.$vs.loading()
                    const manufactureProductLocal = await this.$axios.get(`api/manufacture/product/${this.$route.params.type}/detail`)
                    this.$vs.loading.close()
                    if (!manufactureProductLocal.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: manufactureProductLocal.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    }
                    if (manufactureProductLocal.data.status !== 'DRAFT') {
                        Swal.fire({
                            position: 'top',
                            icon: 'warning',
                            title: "Finished Goods can't be editable, the status  is not draft",
                            showConfirmButton: false,
                            timer: 2500
                        }).then(()=>{
                            this.$router.push(`/app/manufacture/product/${manufactureProductLocal.data.id}/detail`);
                        })
                        return
                    }
                    this.formData.id = manufactureProductLocal.data.id
                    this.formData.name = manufactureProductLocal.data.name
                    manufactureProductLocal.data.manufacture_product_details.forEach((x) => {
                        this.formData.products.push({
                            id: x.semi_finished_material_id,
                            name: x.name,
                            items: x.semi_finished_material.semi_finished_material_items
                        })
                    })
                    this.handleChange()
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

            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/manufacture/product`, this.formData)
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
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>{
                            this.$router.push(`/app/manufacture/product/${resp.data.id}/detail`);
                        })
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
        },
    }
</script>
