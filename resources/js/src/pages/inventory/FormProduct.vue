<template>
    <div class="container-fluid">
        <div class="card my-5">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Product Form</h1>
                <router-link to="/app/inventory/product" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="handleSubmit">
                    <div class="row">
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Product Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.product_name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Category<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select class="form-control" v-model="formData.category" required>
                                    <option v-for="(c, cI) in categories" :value="c.id" :key="cI">{{ c.title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Unit<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select class="form-control" v-model="formData.unit" required>
                                    <option v-for="(c, cI) in units" :value="c.id" :key="cI">{{ c.title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Brand<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select class="form-control" v-model="formData.brand" required>
                                    <option v-for="(c, cI) in brands" :value="c.id" :key="cI">{{ c.title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Quantity Alert<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="number" class="form-control" v-model="formData.quantity_alert" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div v-if="$route.params.type === 'create'" class="form-group">
                                <label>Opening Stock<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="number" class="form-control" v-model="formData.opening_stock" required>
                            </div>
                        </div>
                    </div>
                    <hr class="mb-2">
                    <h3>Price</h3>
                    <div class="row">
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Selling Price<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="number" class="form-control" v-model="formData.selling_price" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Purchase Price<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="number" class="form-control" v-model="formData.purchase_price" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Product Image<span style="
                                color: red;
                                font-weight: bold;
                                font-style: italic;
                            ">*) required</span></label>
                                <input type="file" class="form-control" @change="handleUploadImage">
                            </div>
                            <img :src="formData.product_image" width="100" class="rounded" alt="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea v-model="formData.description" cols="30" rows="5" class="form-control" req></textarea>
                            </div>
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
                    id: "",
                    product_name: "",
                    category: "",
                    unit: "",
                    brand: "",
                    quantity_alert: 0,
                    opening_stock: 0,
                    selling_price: 0,
                    purchase_price: 0,
                    description: "",
                    product_image: "'"
                },
                units: [],
                brands: [],
                categories: []
            }
        },

        mounted() {
            if (this.$route.params.type !== 'create') {
                this.getData()
            }
            this.getDataOther()
        },
        methods: {
            handleUploadImage(e) {
                this.file = e.target.files[0]
                var form_data = new FormData()

                form_data.append('files', this.file)
                form_data.append('folder', 'product')
                this.$vs.loading()
                this.$axios.post('/api/transaction/upload-image',
                    form_data,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data"
                        }
                    }
                ).then((res) => {
                    this.$vs.loading.close()
                    if (res.status == false) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        this.formData.product_image = res.data
                    }

                }).catch((e) => {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                })
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
                        })
                        return
                    }
                    this.formData = resp.data
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
                    this.$vs.loading()
                    this.units = await this.$axios.get(`api/product/unit`)
                    this.brands = await this.$axios.get(`api/product/brand`)
                    this.categories = await this.$axios.get(`api/product/category`)
                    if (this.$route.params.type !== 'create') {
                        for (let i = 0; i < this.units.length; i++) {
                            if (this.units[i].title === this.formData.unit) {
                                this.formData.unit = this.units[i].id
                            }
                        }
                        for (let i = 0; i < this.brands.length; i++) {
                            if (this.brands[i].title === this.formData.brand) {
                                this.formData.brand = this.brands[i].id
                            }
                        }
                        for (let i = 0; i < this.categories.length; i++) {
                            if (this.categories[i].title === this.formData.category) {
                                this.formData.category = this.categories[i].id
                            }
                        }
                    }
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
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/product`, this.formData)
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
                        this.$router.push('/app/inventory/product')
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
