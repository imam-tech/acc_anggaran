<template>
    <div class="container-fluid mb-5">
        <div class="card mb-2">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Cash & Bank Form</h1>
                <router-link to="/app/cash-and-bank" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
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
                                <label>Account Code<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formData.account_code" required>
                            </div>
                            <div class="form-group">
                                <label>Category<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select @change="handleChangeCategory" class="form-control" v-model="formData.category" required>
                                    <option :value="co.value" v-for="(co, coI) in categoryOptions" :key="coI">{{ co.label }}</option>
                                </select>
                            </div>
                            <div v-if="['Cash', 'Bank'].includes(formData.category)" class="form-group">
                                <label>Bank Name</label>
                                <select @click="handleClickBank" class="form-control" v-model="formData.bank_name">
                                    <option v-for="(bank, index) in banks" :value="bank.bank_code" :key="index">{{ bank.name }}</option>
                                </select>
                            </div>
                            <div v-if="formData.bank_name !== '' && ['Cash', 'Bank'].includes(formData.category)" class="form-group">
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
                                Create Account
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
                    account_code: "1111",
                    category: "Cash",
                    bank_name: "",
                    bank_account_number: "",
                    description: ''
                },
                categoryOptions: [{
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
            if (this.$route.params.type !== 'create') {
                this.handleGetData()
            }
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.get(`api/cash-and-bank/${this.$route.params.type}/detail`)
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
                    this.formData.id = resp.data.id
                    this.formData.account_name = resp.data.coa.account_name
                    this.formData.account_code = resp.data.coa.account_number
                    this.formData.category = resp.data.type
                    this.formData.description = resp.data.coa.description
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
                if (this.formData.category === 'Cash') {
                    this.formData.account_code = '1111';
                }

                if (this.formData.category === 'Bank') {
                    this.formData.account_code = '1112';
                }

                if (this.formData.category === 'Credit Card') {
                    this.formData.account_code = '2115';
                }
            },
            async handleSubmit() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.post(`api/cash-and-bank`, this.formData)
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
                    this.$router.push('/app/cash-and-bank')
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
                    this.banks.push({
                        bank_code: "",
                        name: "--Choose Bank--"
                    })
                    let banksData = (await this.$axios.get(`https://old.importir.com/api/list-bank-inquiry?token=syigdfjhagsjdf766et4wff6`)).message.banks
                    banksData.forEach((x) => {
                        this.banks.push(x)
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
        }
    }
</script>
