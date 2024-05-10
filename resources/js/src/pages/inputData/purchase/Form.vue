<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Purchase Form</h1>
                <router-link to="/app/input-data/purchase" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="handleSubmit">
                    <div class="row">
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Vendor<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <div class="d-flex justify-content-between">
                                    <v-select v-model="formData.contact_id" :options="suppliers" :reduce="p => p.id" style="width: 100%" label="name" @input="handleChangeVendor">
                                        <template #search="{attributes, events}">
                                            <input
                                                    class="vs__search"
                                                    :required="!formData.contact_id"
                                                    v-bind="attributes"
                                                    v-on="events"
                                            />
                                        </template>
                                        <span slot="no-options">Vendor not found</span>
                                    </v-select>
                                    <button class="btn btn-warning ml-2" type="button" @click="handleShowAddModalVendor()">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" v-model="formData.contact_email">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Tag</label>
                                <v-select v-model="formData.tags" :options="tags" :reduce="p => p.id" style="width: 100%" label="name" multiple>
                                    <span slot="no-options">Tag not found</span>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>#Transaction Number</label>
                                <input type="text" class="form-control" value="DRAFT" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Transaction date<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="date" class="form-control" v-model="formData.transaction_date" required>
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
                        <div class="col-lg-6 col-xl-3">
                            <div class="form-group">
                                <label>Billing Address</label>
                                <textarea class="form-control" v-model="formData.billing_address" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Product<span v-if="formData.products.length === 0 ? !selectedProduct : false" style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <v-select v-model="selectedProduct" :options="products" :reduce="p => p.id" style="width: 100%" label="name" @input="handleChangeProduct">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                :required="formData.products.length === 0 ? !selectedProduct : false"
                                                v-bind="attributes"
                                                v-on="events"
                                        />
                                    </template>
                                    <span slot="no-options">Product not found</span>
                                </v-select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Units</th>
                                    <th>Unit Price</th>
                                    <th>Sub Total</th>
                                    <th>Tax</th>
                                    <th>Tax Amount</th>
                                    <th>Grand Total</th>
                                    <th>#</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(fp, fpI) in formData.products" :key="fpI">
                                    <td>{{ fp.product }}</td>
                                    <td>
                                        <input type="text" class="form-control" v-model="formData.products[fpI].description">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="formData.products[fpI].quantity" @keyup="handleChange()">
                                    </td>
                                    <td>{{ fp.unit }}</td>
                                    <td>
                                        <input type="number" class="form-control" v-model="formData.products[fpI].unit_price" @keyup="handleChange()">
                                    </td>
                                    <td>{{ fp.sub_total | formatPrice }}</td>
                                    <td>
                                        <v-select v-model="formData.products[fpI].tax_id" :options="taxes" :reduce="p => p.id" style="width: 100%" label="title" @input="handleChangeTax(fpI)">
                                            <span slot="no-options">Tax not found</span>
                                        </v-select>
                                    </td>
                                    <td>{{ fp.tax_amount | formatPrice }}</td>
                                    <td>{{ fp.grand_total | formatPrice }}</td>
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
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Message</label>
                                        <textarea v-model="formData.message" class="form-control" cols="30" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Attachment</label>
                                        <table class="table table-striped">
                                            <tr v-for="(f, fI) in fileImages" :key="fI">
                                                <td>
                                                    <i :class="handleShowIconFile(f.type)"></i>
                                                </td>
                                                <td>
                                                    <span class="d-flex flex-column">
                                                        <span class="text-primary">{{ f.name }}</span>
                                                        <span>{{ handleSizeFile(f.size) }}</span>
                                                    </span>
                                                </td>
                                                <td>
                                                    <button @click="handleDeleteAttachment(fI)" type="button" class="btn btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                        <div v-if="fileImages.length < 5">
                                            <input type="file" class="form-control" @change="handleChangeImage" />
                                            <span>Files can be Excel, Word, PDF, JPG, or PNG (maximum 5 files and 5 MB per file).</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <table class="table">
                                <tr>
                                    <td>Sub Total</td>
                                    <td class="text-right">
                                        {{ subTotal | formatPrice }}
                                    </td>
                                </tr>
                                <tr v-if="taxAmountTotal > 0">
                                    <td>Tax Amount Total</td>
                                    <td class="text-right">
                                        {{ taxAmountTotal | formatPrice }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Grand Total</td>
                                    <td class="text-right">
                                        {{ grandTotal | formatPrice }}
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
            <div class="modal fade" id="addNewVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <form @submit.prevent="handleSubmitAddNewVendor">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Add New Vendor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                            <input type="text" class="form-control" v-model="formAddVendor.name" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" v-model="formAddVendor.email">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Phone</label>
                                            <input type="text" class="form-control" v-model="formAddVendor.phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Identity Number</label>
                                            <input type="text" class="form-control" v-model="formAddVendor.identity_number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>NPWP Number</label>
                                            <input type="text" class="form-control" v-model="formAddVendor.npwp_number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" v-model="formAddVendor.address">
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <label>Trade Payable</label>
                                        <v-select v-model="formAddVendor.purchase_account_id" :options="coas" :reduce="p => p.id" style="width: 100%" label="account_code">
                                            <span slot="no-options">Account not found</span>
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer flex justify-content-between">
                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Close
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
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
                formData: {
                    id: "",
                    contact_id: "",
                    contact_email: "",
                    billing_address: "",
                    transaction_date: (new Date()).toISOString().split('T')[0],
                    due_date: "",
                    products: [],
                    message: "",
                    tags: []
                },
                selectedProduct: "",
                suppliers: [],
                tags: [],
                products: [],
                subTotal: 0,
                taxAmountTotal: 0,
                grandTotal: 0,
                formAddVendor: {
                    id: "",
                    name: "",
                    email: "",
                    phone: "",
                    sale_account_id: null,
                    purchase_account_id: null,
                    identity_number: "",
                    npwp_number: "",
                    address: "",
                    type: "vendor"
                },
                taxes: [],
                fileImages: [],
                coas: []
            }
        },

        mounted() {
            this.getDataOther()
            if (this.$route.params.type !== 'create') {
                this.handleGet()
            }
        },
        methods: {
            handleDeleteAttachment(index) {
                this.fileImages = this.fileImages.filter((item, ind) => ind !== index)
            },

            handleChangeVendor(e) {
                const selectVendor = this.suppliers.find((x) => x.id === e)
                this.formData.contact_email = selectVendor.email
            },

            async handleGet() {
                try {
                    this.$vs.loading()
                    const purchaseLocal = await this.$axios.get(`api/input-data/purchase/${this.$route.params.type}/detail`)
                    this.$vs.loading.close()
                    if (!purchaseLocal.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: purchaseLocal.message,
                            showConfirmButton: false,
                            timer: 2500
                        })
                        return
                    }
                    if (purchaseLocal.data.paid_date) {
                        Swal.fire({
                            position: 'top',
                            icon: 'warning',
                            title: "Purchase can't be editable, the status is already paid",
                            showConfirmButton: false,
                            timer: 2500
                        }).then(()=>{
                            this.$router.push(`/app/input-data/purchase/${purchaseLocal.data.id}/detail`);
                        })
                        return
                    }
                    this.formData.id = purchaseLocal.data.id
                    this.formData.contact_id = purchaseLocal.data.contact_id
                    this.formData.contact_email = purchaseLocal.data.contact_email ?? null
                    this.formData.billing_address = purchaseLocal.data.billing_address ?? ''
                    this.formData.transaction_date = purchaseLocal.data.transaction_date
                    this.formData.due_date = purchaseLocal.data.due_date ?? ''
                    this.formData.message = purchaseLocal.data.message ?? ''
                    purchaseLocal.data.tag_details.forEach((x) => {
                        this.formData.tags.push(x.tag_id)
                    })
                    purchaseLocal.data.purchase_products.forEach((x) => {
                        this.formData.products.push({
                            id: x.product_id,
                            product: x.product.name,
                            description: x.description ?? '',
                            quantity: x.quantity,
                            unit: x.unit,
                            unit_price: x.unit_price,
                            sub_total: 0,
                            tax_id: x.tax_id ?? '',
                            tax_percentage: x.tax_percentage ?? '',
                            tax_amount: 0,
                            grand_total: 0
                        })
                    })
                    purchaseLocal.data.purchase_attachments.forEach((x) => {
                        this.fileImages.push({
                            name: x.name,
                            type: x.type,
                            size: x.size,
                            ori: x.id
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
                console.log("oke")
                const formData = new FormData()
                formData.append('id', this.formData.id)
                formData.append('contact_id', this.formData.contact_id)
                formData.append('contact_email', this.formData.contact_email ?? '')
                formData.append('tags', JSON.stringify(this.formData.tags))
                formData.append('billing_address', this.formData.billing_address)
                formData.append('products', JSON.stringify(this.formData.products))
                formData.append('transaction_date', this.formData.transaction_date)
                formData.append('due_date', this.formData.due_date)
                formData.append('message', this.formData.message)
                this.fileImages.forEach((x, i) => {
                    formData.append(`attachment${i}`, x.ori)
                })

                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/input-data/purchase`,
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
                        this.$router.push(`/app/input-data/purchase/${resp.data.id}/detail`)
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

            handleSizeFile(size) {
                if (size < 1000000)  {
                    return parseFloat(size/1000).toFixed(0) + ' Kb'
                } else {
                    return parseFloat(size / 1000000).toFixed(2) + ' Mb'
                }
            },

            handleShowIconFile(type) {
                if (type === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') return 'fas fa-file-word-o';
                if (type === 'application/pdf') return 'fas fa-file-pdf-o';
                if (type === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') return 'fas fa-file-excel-o'
                if (['image/jpg', 'image/jpeg'].includes(type)) return 'fas fa-file-image-o'
                if (type === 'image/png') return 'fa-picture-o'
            },

            handleChangeImage(e) {
                const fileSel = e.target.files[0]
                if (fileSel.size > 5000000) {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: "Maximum size of file is 5 Mb",
                        showConfirmButton: false,
                        timer: 2000
                    })
                    return
                }
                const types = ['application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/pdf',
                    'image/jpg', 'image/jpeg', 'image/png'];
                if (!types.includes(fileSel.type)) {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: "Please input the type of file from Excel, Word, PDF, JPG, or PNG",
                        showConfirmButton: false,
                        timer: 2000
                    })
                    return
                }
                this.fileImages.push({
                    name: fileSel.name,
                    type: fileSel.type,
                    size: fileSel.size,
                    ori: fileSel
                })
            },

            handleChangeTax(index) {
                const selectTax = this.taxes.find((x) => x.id === this.formData.products[index].tax_id)
                this.formData.products[index].tax_percentage = selectTax.amount
                this.handleChange()
            },

            handleShowAddModalVendor() {
                $("#addNewVendor").modal('show')
            },

            async handleSubmitAddNewVendor() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/master-data/contact`, this.formAddVendor)
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
                        $("#addNewVendor").modal('hide')
                        this.getDataOther()
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

            handleChange() {
                let grandTotal = 0
                let taxAmountTotal = 0
                let subTotal = 0
                const prods = this.formData.products
                prods.forEach((x, i) => {
                    this.formData.products[i].sub_total = x.quantity * x.unit_price
                    let taxAmount = 0;
                    if (x.tax_id) {
                        taxAmount = x.tax_percentage * this.formData.products[i].sub_total / 100;
                    }
                    this.formData.products[i].tax_amount = taxAmount;
                    this.formData.products[i].grand_total = this.formData.products[i].sub_total + this.formData.products[i].tax_amount;
                    subTotal = subTotal + this.formData.products[i].sub_total
                    grandTotal = grandTotal + this.formData.products[i].grand_total
                    taxAmountTotal = taxAmountTotal + this.formData.products[i].tax_amount
                })
                this.subTotal = subTotal
                this.taxAmountTotal = taxAmountTotal
                this.grandTotal = grandTotal
            },

            handleDeleteProduct(index) {
                this.formData.products = this.formData.products.filter((item, ind) => ind !== index)
                this.handleChange()
                this.selectedProduct = '';
            },

            handleChangeProduct(e) {
                const selectProdLocal = this.products.find((x) => x.id === e)
                this.formData.products.push({
                    id: selectProdLocal.id,
                    product: selectProdLocal.name,
                    description: selectProdLocal.description ?? '',
                    quantity: 1,
                    unit: selectProdLocal.unit ? selectProdLocal.unit.name :  'Unit',
                    unit_price: selectProdLocal.unit_purchase_price,
                    sub_total: 0,
                    tax_id: selectProdLocal.purchase_tax_id,
                    tax_percentage: selectProdLocal.purchase_tax ? selectProdLocal.purchase_tax.amount : 0,
                    tax_amount: 0,
                    grand_total: 0
                })
                this.handleChange()
            },

            async getDataOther() {
                try {
                    this.$vs.loading()
                    this.suppliers = await this.$axios.get(`api/master-data/contact?type=vendor`)
                    this.products = await this.$axios.get(`api/master-data/product?is_purchase=1`)
                    this.taxes = await this.$axios.get(`api/master-data/taxes?is_archive=no`)
                    this.tags = await this.$axios.get(`api/master-data/tag?is_sale=1&is_archive=no`)
                    this.coas = await this.$axios.get(`api/master-data/coa?is_active=1`)
                    this.$vs.loading.close()
                } catch (e) {
                    this.$vs.loading.close()
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            },
        }
    }
</script>
