<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Customers Form</h1>
                <router-link to="/app/sales/customers" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
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
                                <input type="text" class="form-control" v-model="formData.name" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" v-model="formData.email">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Phone<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.phone" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Identity Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.identity_number" required>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>NPWP Number</label>
                                <input type="text" class="form-control" v-model="formData.npwp_number">
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-4">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" class="form-control" v-model="formData.address">
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
                    name: "",
                    email: "",
                    phone: "",
                    identity_number: "",
                    npwp_number: "",
                    address: ""
                },

            }
        },

        mounted() {
            if (this.$route.params.type !== 'create') {
                this.getData()
            }
        },
        methods: {
            async handleSubmit() {

                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/sales/customer`, this.formData)
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
                        this.$router.push('/app/sales/customers')
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
                    const resp = await this.$axios.get(`api/sales/customer/${this.$route.params.type}/detail`)
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
        }
    }
</script>
