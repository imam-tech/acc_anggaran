<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Contact Form</h1>
                <router-link to="/app/master-data/contact" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="handleSubmit()">
                    <div class="row">
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.name" placeholder="Name of person, company or other" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" v-model="formData.email" placeholder="Must be email format">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" v-model="formData.phone" placeholder="Phone Number Here">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Identity Number</label>
                                <input type="text" class="form-control" v-model="formData.identity_number" placeholder="Example: 123456789">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>NPWP Number</label>
                                <input type="text" class="form-control" v-model="formData.npwp_number" placeholder="123456789">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" v-model="formData.address" placeholder="The contact address">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Account Receivable</label>
                            <v-select v-model="formData.sale_account_id" :options="coas" :reduce="p => p.id" style="width: 100%" label="account_code">
                                <span slot="no-options">Account not found</span>
                            </v-select>
                        </div>
                        <div class="col-lg-6">
                            <label>Trade Payable</label>
                            <v-select v-model="formData.purchase_account_id" :options="coas" :reduce="p => p.id" style="width: 100%" label="account_code">
                                <span slot="no-options">Account not found</span>
                            </v-select>
                        </div>
                    </div>
                    <hr>
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
                    name: "",
                    email: "",
                    phone: "",
                    identity_number: "",
                    npwp_number: "",
                    address: "",
                    sale_account_id: '',
                    purchase_account_id: ''
                },
                coas: []
            }
        },

        mounted() {
            this.getOtherData()
            if (this.$route.params.type !== 'create') {
                this.getData()
            }
        },
        methods: {
            async handleSubmit() {

                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/master-data/contact`, this.formData)
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
                        this.$router.push('/app/master-data/contact')
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
            async getData() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.get(`api/master-data/contact/${this.$route.params.type}/detail`)
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
                    console.log("form", this.formData)
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

            async getOtherData() {
                try {
                    this.$vs.loading()
                    this.coas = await this.$axios.get(`api/master-data/coa?is_active=1`)
                    const coaLocals = await this.$axios.get(`api/master-data/coa?is_active=1&coa_name=BANK`)
                    coaLocals.forEach((x) => this.coas.push(x))
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
        }
    }
</script>
