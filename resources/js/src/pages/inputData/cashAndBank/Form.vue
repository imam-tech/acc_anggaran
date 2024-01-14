<template>
    <div class="container-fluid mb-5">
        <div class="card mb-2">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Cash & Bank Form</h1>
                <router-link to="/app/input-data/cash-and-bank" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <form @submit.prevent="handleSubmit()">
                    <div class="row">
                        <div class="col-xl-4"></div>
                        <div class="col-12 col-xl-4">
                            <div class="form-group">
                                <label>Account Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.account_name" required>
                            </div>
                            <div class="form-group">
                                <label>Account Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.account_number" required>
                            </div>
                            <div class="form-group">
                                <label>Category<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select @change="handleChangeCategory" class="form-control" v-model="formData.type" required>
                                    <option :value="co.value" v-for="(co, coI) in typeOptions" :key="coI">{{ co.label }}</option>
                                </select>
                            </div>
                            <div v-if="['Cash', 'Bank'].includes(formData.type)" class="form-group">
                                <label>Bank Name</label>
                                <v-select v-model="formData.bank_name" :options="banks" :reduce="p => p.bank_code" style="width: 100%" label="name">
                                    <span slot="no-options">Bank Not Found</span>
                                </v-select>
                            </div>
                            <div v-if="formData.bank_name !== '' && ['Cash', 'Bank'].includes(formData.type)" class="form-group">
                                <label>Bank Account Number</label>
                                <input type="text" v-model="formData.bank_account_number" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" cols="30" rows="5" v-model="formData.description"></textarea>
                            </div>
                        </div>
                        <div class="col-xl-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-xl-4"></div>
                        <div class="col-xl-4 text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ formData.id === '' ? 'Create' : 'Update' }} Account
                            </button>
                        </div>
                        <div class="col-xl-4"></div>
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
                    account_name: "",
                    account_number: "1111",
                    type: "Cash",
                    bank_name: "",
                    bank_account_number: "",
                    description: ''
                },
                typeOptions: [{
                    label: 'Cash',
                    value: 'Cash'
                },{
                    label: 'Bank',
                    value: 'Bank'
                },{
                    label: 'Credit Card',
                    value: 'Credit Card'
                }],
                banks: [],
            }
        },

        mounted() {
            this.handleClickBank()
            if (this.$route.params.type !== 'create') {
                this.handleGetData()
            }
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.get(`api/input-data/cash-and-bank/${this.$route.params.type}/detail`)
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
                    this.formData.account_name = resp.data.coa.account_name
                    this.formData.account_number = resp.data.coa.account_number
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
            handleClickBank() {
                if (this.banks.length === 0) {
                    this.getDataBank()
                }
            },
            handleChangeCategory() {
                if (this.formData.type === 'Cash') {
                    this.formData.account_number = '1111';
                }

                if (this.formData.type === 'Bank') {
                    this.formData.account_number = '1112';
                }

                if (this.formData.type === 'Credit Card') {
                    this.formData.account_number = '2115';
                }
            },
            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/input-data/cash-and-bank`, this.formData)
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
                    this.$router.push('/app/input-data/cash-and-bank')
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
            async getDataBank() {
                try {
                    this.$vs.loading()
                    this.banks = (await this.$axios.get(`https://old.importir.com/api/list-bank-inquiry?token=syigdfjhagsjdf766et4wff6`)).message.banks
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
