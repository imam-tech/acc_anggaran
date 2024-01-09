<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Transaction Form</h1>
                <router-link v-if="$route.params.id === 'create'" to="/app/transaction" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
                <router-link v-else :to="'/app/transaction/'+ $route.params.id+'/detail'" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fas fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-xl-8">
                        <form @submit.prevent="submitProcess">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Company<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <v-select v-model="selectedCompany" :options="companies" :reduce="p => p.id" style="width: 100%" label="title" @input="handleChangeCompany">
                                            <template #search="{attributes, events}">
                                                <input
                                                        class="vs__search"
                                                        :required="!selectedCompany"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                />
                                            </template>
                                            <span slot="no-options">Company not found</span>
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <input type="text" class="form-control" v-model="formData.title" placeholder="Title" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Project<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <v-select v-model="formData.project_id" :options="projects" :reduce="p => p.id" style="width: 100%" label="title">
                                            <template #search="{attributes, events}">
                                                <input
                                                        class="vs__search"
                                                        :required="!formData.project_id"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                />
                                            </template>
                                            <span slot="no-options">Project not found</span>
                                        </v-select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" v-model="formData.description"></textarea>
                            </div>
                            <hr>
                            <div class="text-center">Bank Account</div>
                            <hr>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Bank<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <v-select v-model="formData.bank" :options="banks" :reduce="p => p.bank_code" style="width: 100%" label="name" @input="getDataInquiry()">
                                            <template #search="{attributes, events}">
                                                <input
                                                        class="vs__search"
                                                        :required="!formData.bank"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                />
                                            </template>
                                            <span slot="no-options">Bank not found</span>
                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Account<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <v-select v-model="formData.inquiry_id" :options="inquiries" :reduce="p => p.id" style="width: 100%" label="label">
                                            <template #search="{attributes, events}">
                                                <input
                                                        class="vs__search"
                                                        :required="!formData.inquiry_id"
                                                        v-bind="attributes"
                                                        v-on="events"
                                                />
                                            </template>
                                            <span slot="no-options">Account not found</span>
                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-center">
                                    <button type="button" @click="showAddInquiry()" class="btn btn-info float-right mt-3">
                                        <i class="fas fa-plus"></i> Bank Account
                                    </button>
                                </div>
                            </div>

                            <hr class="mt-5">
                            <div class="text-center">Items</div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <button type="button" @click="showAddItem()" class="btn btn-success float-right mt-3 mr-3">
                                        <i class="fas fa-plus"></i> Items
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th class="text-center">Title</th>
                                            <th class="text-center">Amount</th>
                                            <th class="text-center">Link</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in formData.items" :key="index">
                                            <td>{{ item.title }}</td>
                                            <td>{{ item.amount }}</td>
                                            <td>
                                                <a :href="item.attachment" target="_blank"><i class="fas fa-link"></i></a>
                                            </td>
                                            <td class="text-right">
                                                <button type="button" class="btn btn-warning" @click="showEditItem(item, index)">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </button>
                                                <button class="btn btn-danger" type="button" @click="handleDeleteItem(index)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary float-right mt-3 mr-3">
                                <i class="fas fa-save"></i> Submit
                            </button>
                        </form>
                    </div>
                    <div class="col-xl-4">
                        <label>Finance Approval</label>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <tbody>
                            <tr v-for="(admin, index) in company.company_admins" :key="index">
                                <td v-if="admin.user">
                                    <div class="row">
                                        <div class="col-2">
                                            <span class="avatar">{{ admin.user.name | getShortName }}</span>
                                        </div>
                                        <div class="col-10">
                                            <label>{{ admin.user.name }}</label>
                                            <br>
                                            <label>{{ admin.user.email }}</label>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-right">{{ admin.title }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addInquiry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleAddInquiry">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Inquiry</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Bank Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <v-select v-model="formInquiry.bank" :options="banks" :reduce="p => p.bank_code" style="width: 100%" label="name">
                                    <template #search="{attributes, events}">
                                        <input
                                                class="vs__search"
                                                :required="!formInquiry.bank"
                                                v-bind="attributes"
                                                v-on="events"
                                        />
                                    </template>
                                    <span slot="no-options">Bank not found</span>
                                </v-select>
                            </div>
                            <div class="form-group">
                                <label>Account Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formInquiry.account_number" required>
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
        <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form @submit.prevent="handleAddItem">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formItem.title" required>
                            </div>
                            <div class="form-group">
                                <label>Amount<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="number" class="form-control" v-model="formItem.amount" required>
                            </div>
                            <div class="form-group">
                                <label>Attachment<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="file" class="form-control" @change="handleUploadImage">
                                <label class="text-danger"><i><b>The size maximize of image is 800 pixel</b></i></label>
                            </div>
                            <div class="form-group">
                                <label>Note</label>
                                <textarea class="form-control" v-model="formItem.note"></textarea>
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
</template>

<script>

    export default {
        name:'Detail',
        data() {
            return {
                formData: {
                    id: "",
                    title: "",
                    project_id: "",
                    description: "",
                    bank:"",
                    inquiry_id: "",
                    items: []
                },
                formInquiry: {
                    bank: "",
                    account_number: "",
                    company_id: ""
                },
                company: "",
                projects: [],
                banks: [],
                inquiries: [],
                formItem: {
                    type: '',
                    title: '',
                    amount: "",
                    note: "",
                    attachment: "https://firebasestorage.googleapis.com/v0/b/anggaran-v2.appspot.com/o/anggaran-new%2F1688468222456.png?alt=media&token=b398d9bc-38b1-4af5-a948-d2c4b3c8940b"
                },
                companies: [],
                selectedCompany: ""
            }
        },

        mounted() {
            this.getListCompany()
            this.getDataBank()
            if (this.$route.query.companyId !== undefined) {
                this.selectedCompany = parseInt(this.$route.query.companyId)
                this.getDataProject()
                this.getDataCompany()
            }
            if (this.$route.params.id !== 'create') {
                this.getDataTransaction()
            }
        },
        methods: {
            handleChangeCompany() {
                this.getDataProject()
                this.getDataCompany()
            },
            handleUploadImage(e) {
                this.file = e.target.files[0]
                var form_data = new FormData()

                form_data.append('files', this.file)
                form_data.append('folder', 'transaction')
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
                            position: 'top',
                            icon: 'error',
                            title: res.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        this.formItem.attachment = res.data
                        console.log(res.data)
                    }

                }).catch((e) => {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: e.message,
                        showConfirmButton: false,
                        timer: 2000
                    })
                })
            },
            async submitProcess() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/transaction', this.formData)
                    this.$vs.loading.close()
                    if (!respSave.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>{
                            this.$router.push(`/app/transaction/${respSave.data.id}/detail`);
                        })
                    }
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
            showEditItem(item, index) {
                this.formItem = {
                    type: index,
                    title: item.title,
                    amount: item.amount,
                    note: item.note,
                    attachment: "https://firebasestorage.googleapis.com/v0/b/anggaran-v2.appspot.com/o/anggaran-new%2F1688468222456.png?alt=media&token=b398d9bc-38b1-4af5-a948-d2c4b3c8940b"
                }
                $("#addItem").modal("show")
            },
            handleDeleteItem(index) {
                this.formData.items = this.formData.items.filter((item, ind) => ind !== index)
            },
            handleAddItem() {
                if (this.formItem.title === "" || this.formItem.amount === "") {
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: "Please fill title and amount",
                        showConfirmButton: false,
                        timer: 2000
                    })
                    return
                }
                if (this.formItem.type === "") {
                    this.formData.items.push(this.formItem)
                } else {
                    this.$set(this.formData.items, this.formItem.type, this.formItem);
                }
                $("#addItem").modal("hide")
            },
            showAddItem() {
                this.formItem = {
                    type: "",
                    title: '',
                    amount: "",
                    note: "",
                    attachment: "https://firebasestorage.googleapis.com/v0/b/anggaran-v2.appspot.com/o/anggaran-new%2F1688468222456.png?alt=media&token=b398d9bc-38b1-4af5-a948-d2c4b3c8940b"
                }
                $("#addItem").modal("show")
            },
            showAddInquiry() {
                $("#addInquiry").modal("show")
            },
            async handleAddInquiry() {
                try {
                    this.formInquiry.company_id = this.$route.params.companyId
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/inquiry', this.formInquiry)
                    this.$vs.loading.close()
                    if (!respSave.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        this.formData.bank = this.formInquiry.bank
                        this.getDataInquiry()
                    } else {
                        $("#addInquiry").modal("hide")
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(async ()=>{
                            this.getDataInquiry()
                        })
                    }
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
            async getListCompany() {
                try {
                    this.$vs.loading()
                    const compLocals = await this.$axios.get(`api/configuration/company`)
                    compLocals.forEach((x) => {
                        this.companies.push(x)
                    })
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
            async getDataCompany() {
                try {
                    this.$vs.loading()
                    const respCompany = await this.$axios.get(`api/configuration/company/${this.selectedCompany}/detail`)
                    this.$vs.loading.close()
                    if (!respCompany.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: respCompany.message,
                            showConfirmButton: false,
                            timer: 2000
                        })
                        return
                    }
                    this.company = respCompany.data
                    if (this.company.company_admins[0].user === null) {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: "The finance approval is  not available, please contact your administrator.",
                            showConfirmButton: false,
                            timer: 2000
                        }).then(()=>{
                            this.$router.push(`/app/configuration/company/${this.selectedCompany}/detail`);
                        })
                    }
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
            async getDataInquiry() {
                try {
                    this.$vs.loading()
                    this.inquiries = []
                    const inqLocals = await this.$axios.get(`api/inquiry?bank=${this.formData.bank}`)
                    inqLocals.forEach((x) => {
                        this.inquiries.push({
                            id: x.id,
                            label: x.name + ' ' + x.account_number
                        })
                        if (x.account_number === this.formData.inquiry_id) {
                            this.formData.inquiry_id = x.id
                        }
                    })
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
            async getDataTransaction() {
                try {
                    this.$vs.loading()
                    const resp = await this.$axios.get(`api/transaction/${this.$route.params.id}/detail`)
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
                    if (!resp.data.current_status !== 'requested') {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: "This transaction is not editable,the status is not requested",
                            showConfirmButton: false,
                            timer: 2000
                        }).then(async ()=>{
                            this.$router.push('/app/transaction')
                        })
                        return
                    }
                    this.selectedCompany = resp.data.company_id
                    await this.handleChangeCompany()
                    this.formData.id = resp.data.id
                    this.formData.title = resp.data.title
                    this.formData.project_id = resp.data.project_id
                    await this.getDataProject()
                    this.formData.description = resp.data.description
                    this.formData.bank = resp.data.bank
                    this.formData.inquiry_id = resp.data.account_number
                    await this.getDataInquiry()
                    resp.data.transaction_items.forEach((x) => {
                        this.formData.items.push({
                            type: "",
                            title: x.title,
                            amount: x.input_amount,
                            note: x.note,
                            attachment: x.attachment
                        })
                    })

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
            async getDataProject() {
                try {
                    this.$vs.loading()
                    this.projects = await this.$axios.get(`api/project?company_id=${this.selectedCompany}&project_user=1`)
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
            async getDataBank() {
                try {
                    this.$vs.loading()
                    this.banks = (await this.$axios.get(`https://old.importir.com/api/list-bank-inquiry?token=syigdfjhagsjdf766et4wff6`)).message.banks
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
