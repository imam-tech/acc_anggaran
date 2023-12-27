<template>
    <div class="container-fluid">
        <div class="card my-5">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Product Form</h1>
                <router-link to="/app/product" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="handleSubmit">
                    <div class="row">
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" class="form-control" @change="handleChangeImage">
                            </div>
                            <img :src="formData.image" width="100" class="rounded" alt="">
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>SKU Code</label>
                                <input type="text" class="form-control" v-model="formData.sku_code">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Category</label>
                                <div class="d-flex justify-content-between">
                                    <v-select v-model="formData.product_category_id" :options="categories" :reduce="p => p.id" style="width: 100%" label="name">
                                        <span slot="no-options">Category not found, click + icon to create</span>
                                    </v-select>
                                    <button class="btn btn-warning ml-2" type="button" @click="handleShowAddModalCategory()">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Unit</label>
                                <div class="d-flex justify-content-between">
                                    <v-select v-model="formData.product_unit_id" :options="units" :reduce="p => p.id" style="width: 100%" label="name">
                                        <span slot="no-options">Unit not found, click + icon to create</span>
                                    </v-select>
                                    <button class="btn btn-warning ml-2" type="button" @click="handleShowAddModalUnit()">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea v-model="formData.description" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <div class="row">
                        <div class="col-12">
                            <input type="checkbox" v-model="formData.is_purchase" /> I buy this item
                        </div>
                    </div>
                    <div v-if="formData.is_purchase" class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Unit Purchase Price</label>
                                <input type="number" class="form-control" v-model="formData.unit_purchase_price" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Purchase Account</label>
                                <v-select v-model="formData.purchase_account_id" :options="accounts" :reduce="p => p.id" style="width: 100%" label="account_code">
                                    <span slot="no-options">Account not found</span>
                                </v-select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Purchase Tax</label>
                                <v-select v-model="formData.purchase_tax_id" :options="taxes" :reduce="p => p.id" style="width: 100%" label="title">
                                    <span slot="no-options">Tax not found</span>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <div class="row">
                        <div class="col-12">
                            <input type="checkbox" v-model="formData.is_sale" /> I sell this item
                        </div>
                    </div>
                    <div v-if="formData.is_sale" class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Unit Sale Price</label>
                                <input type="number" class="form-control" v-model="formData.unit_sale_price" />
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Sale Account</label>
                                <v-select v-model="formData.sale_account_id" :options="accounts" :reduce="p => p.id" style="width: 100%" label="account_code">
                                    <span slot="no-options">Account not found</span>
                                </v-select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Sale Tax</label>
                                <v-select v-model="formData.sale_tax_id" :options="taxes" :reduce="p => p.id" style="width: 100%" label="title">
                                    <span slot="no-options">Tax not found</span>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <UnitCrud :get-data="getDataOther" :form-data="formAddUnit" :label-modal="labelModal"></UnitCrud>
            <CategoryCrud :get-data="getDataOther" :form-data="formAddCategory" :label-modal="labelModal"></CategoryCrud>
        </div>
    </div>
</template>

<script>
    import UnitCrud from './components/UnitCrud'
    import CategoryCrud from './components/CategoryCrud'

    export default {
        name:'Detail',
        components: {UnitCrud, CategoryCrud},
        data() {
            return {
                formData: {
                    id: "",
                    name: "",
                    sku_code: "",
                    product_category_id: "",
                    product_unit_id: "",
                    description: "",
                    is_sale: 0,
                    unit_sale_price: 0,
                    sale_account_id: '',
                    sale_tax_id: '',
                    is_purchase: 0,
                    unit_purchase_price: 0,
                    purchase_account_id: '',
                    purchase_tax_id: '',
                },
                units: [],
                categories: [],
                fileImage: "",
                accounts: [],
                taxes: [],
                formAddUnit: {
                    id: "",
                    name: ''
                },
                formAddCategory: {
                    id: "",
                    name: "",
                    image: ""
                },
                labelModal: 'Add'
            }
        },

        mounted() {
            this.initiateData()
        },
        methods: {

            handleShowAddModalUnit() {
                this.formAddUnit = {
                    'id': "",
                    'name': ""
                }
                $("#addProductUnit").modal('show')
            },

            handleShowAddModalCategory() {
                this.formAddCategory = {
                    id: "",
                    name: "",
                    image: ""
                }
                $("#addProductCategory").modal('show')
            },

            async initiateData() {
                if (this.$route.params.type !== 'create') {
                    await this.getData()
                }
                this.getDataOther()
            },

            handleChangeImage(e) {
                this.fileImage = e.target.files[0]
            },

            async getData() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.get(`api/product/${this.$route.params.type}/detail`)
                    this.$vs.loading.close()
                    if (!resp.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        }).then(()=>{
                            this.$router.push(`/app/product`);
                        })
                        return
                    }
                    this.formData = resp.data
                    this.formData.sku_code = this.formData.sku_code ?? ''
                    this.formData.product_category_id = this.formData.product_category_id ?? ''
                    this.formData.product_unit_id = this.formData.product_unit_id ?? ''
                    this.formData.description = this.formData.description ?? ''
                    this.formData.unit_sale_price = this.formData.unit_sale_price ?? ''
                    this.formData.sale_account_id = this.formData.sale_account_id ?? ''
                    this.formData.sale_tax_id = this.formData.sale_tax_id ?? ''
                    this.formData.unit_purchase_price = this.formData.unit_purchase_price ?? ''
                    this.formData.purchase_account_id = this.formData.purchase_account_id ?? ''
                    this.formData.purchase_tax_id = this.formData.purchase_tax_id ?? ''
                    this.formData.product_category_id = this.formData.product_category_id ? parseInt(this.formData.product_category_id) : ''
                    this.formData.product_unit_id = this.formData.product_unit_id ? parseInt(this.formData.product_unit_id) : ''
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

            async getDataOther() {
                try {
                    console.log("oke 2")
                    this.$vs.loading()
                    this.units = await this.$axios.get(`api/product/unit?is_archive=no`)
                    this.categories = await this.$axios.get(`api/product/category?is_archive=no`)
                    this.accounts = await this.$axios.get(`api/coa?is_active=1&coa_name=PENDAPATAN`)
                    this.taxes = await this.$axios.get(`api/tax?is_archive=no`)
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

            async handleSubmit() {
                try {
                    const formData = new FormData()
                    formData.append('id', this.formData.id)
                    formData.append('name', this.formData.name)
                    formData.append('image', this.fileImage)
                    formData.append('sku_code', this.formData.sku_code)
                    formData.append('product_category_id', this.formData.product_category_id)
                    formData.append('product_unit_id', this.formData.product_unit_id)
                    formData.append('description', this.formData.description)
                    formData.append('is_sale', this.formData.is_sale ? 1 : 0)
                    formData.append('unit_sale_price', this.formData.unit_sale_price)
                    formData.append('sale_account_id', this.formData.sale_account_id)
                    formData.append('sale_tax_id', this.formData.sale_tax_id)
                    formData.append('is_purchase', this.formData.is_purchase ? 1 : 0)
                    formData.append('unit_purchase_price', this.formData.unit_purchase_price)
                    formData.append('purchase_account_id', this.formData.purchase_account_id)
                    formData.append('purchase_tax_id', this.formData.purchase_tax_id)

                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/product`,
                        formData, {
                            headers: {
                                "Content-Type": "multipart/form-data"
                            }
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
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        this.$router.push('/app/product')
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
        }
    }
</script>
