<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company Form</h1>
                <router-link to="/backend/app" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form  @submit.prevent="submitProcess()">
                    <div class="row">
                        <div class="col-md-6 col-xl-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Is Multiple Company *)</div>
                                </div>
                                <select class="form-control" v-model="formData.is_multiple_company" required>
                                    <option value="">--Choose One--</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Is Whitelist *)</div>
                                </div>
                                <select class="form-control" v-model="formData.is_whitelist" required>
                                    <option value="">--Choose One--</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Domain {{ formData.is_whitelist == 1 ? '*)' : '' }}</div>
                                </div>
                                <input type="text" class="form-control" v-model="formData.domain" placeholder="Example: fat.com" :required="formData.is_whitelist == 1 ? true : false"/>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary float-right mt-3 mr-3">
                        <i class="fas fa-save"></i> Submit
                    </button>
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
                    domain: "",
                    is_whitelist: "",
                    is_multiple_company: ""
                }
            }
        },

        mounted() {
            if (this.$route.params.id !== 'create') {
                this.getData()
            }
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.get(`api/backend/app/${this.$route.params.id}/detail`)
                    this.$vs.loading.close()
                    if (!resp.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: resp.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        return
                    }
                    this.formData.id = resp.data.id
                    this.formData.is_whitelist = resp.data.is_whitelist
                    this.formData.is_multiple_company = resp.data.is_multiple_company
                    this.formData.domain = resp.data.domain
                } catch (e) {
                    console.log("oke", e.message)
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
            async submitProcess() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/backend/app', this.formData)
                    this.$vs.loading.close()
                    if (!respSave.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>{
                            this.$router.push(`/backend/app/${respSave.data.id}/detail`);
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
            }
        }
    }
</script>
