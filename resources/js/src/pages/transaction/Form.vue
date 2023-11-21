<template>
    <div class="container-fluid">
        <div class="card">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Transaction Form</h1>
                <router-link to="/app/transaction" class="btn btn-success float-right mt-3 mr-3">
                    <i class="fa fa-arrow-left"></i> Back
                </router-link>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <form>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <input type="text" class="form-control" v-model="formData.title" placeholder="Title">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Project<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select v-model="formData.project_id" class="form-control">
                                            <option v-for="(project, index) in projects" :value="project.id" :key="index">{{ project.title }}</option>
                                        </select>
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
                                        <select v-model="formData.bank" class="form-control" @change="getDataInquiry()">
                                            <option v-for="(bank, index) in banks" :value="bank.bank_code" :key="index">{{ bank.name }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Account<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                        <select v-model="formData.inquiry_id" class="form-control">
                                            <option v-for="(inquiry, index) in inquiries" :value="inquiry.id" :key="index">{{ inquiry.name }}-{{ inquiry.account_number }} </option>
                                        </select>
                                    </div>
                                </div>
                                <button type="button" @click="showAddInquiry()" class="btn btn-info float-right mt-3">
                                    <i class="fa fa-plus"></i> Bank Account
                                </button>
                            </div>

                            <hr>
                            <div class="text-center">Items</div>
                            <hr>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <button type="button" @click="showAddItem()" class="btn btn-warning float-right mt-3 mr-3">
                                        <i class="fa fa-plus"></i> Items
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Amount</th>
                                            <th>Link</th>
                                            <th>#</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, index) in formData.items" :key="index">
                                            <td>{{ item.title }}</td>
                                            <td>{{ item.amount }}</td>
                                            <td>{{ item.attachment }}</td>
                                            <td>
                                                <button type="button" class="btn btn-warning" @click="showEditItem(item, index)">
                                                    <i class="fa fa-pencil"></i>
                                                </button>
                                                <button class="btn btn-danger" type="button" @click="handleDeleteItem(index)">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <button type="button" @click="submitProcess()" class="btn btn-primary float-right mt-3 mr-3">
                                <i class="fa fa-save"></i> Submit
                            </button>
                        </form>
                    </div>
                    <div class="col-4">
                        <label>Finance Approval</label>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <tbody>
                            <tr v-for="(admin, index) in company.company_admins" :key="index">
                                <td>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Inquiry</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form>
                            <div class="form-group">
                                <label>Bank Name<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <select v-model="formInquiry.bank" class="form-control">
                                    <option v-for="(bank, index) in banks" :value="bank.bank_code" :key="index">{{ bank.name }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Account Number<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formInquiry.account_number">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="handleAddInquiry()">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form>
                            <div class="form-group">
                                <label>Title<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formItem.title">
                            </div>
                            <div class="form-group">
                                <label>Amount<span style="
                                    color: red;
                                    font-weight: bold;
                                    font-style: italic;
                                ">*) required</span></label>
                                <input type="text" class="form-control" v-model="formItem.amount">
                            </div>
                            <div class="form-group">
                                <label>Note</label>
                                <textarea class="form-control" v-model="formItem.note"></textarea>
                            </div>
                            <!--<div class="form-group">-->
                                <!--<label>Attachment<span style="-->
                                    <!--color: red;-->
                                    <!--font-weight: bold;-->
                                    <!--font-style: italic;-->
                                <!--">*) required</span></label>-->
                                <!--<input type="file" class="form-control">-->
                            <!--</div>-->
                        </form>
                    </div>
                    <div class="modal-footer flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="handleAddItem()">Save changes</button>
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
                    title: "",
                    project_id: "",
                    description: "",
                    bank:"",
                    inquiry_id: "",
                    items: []
                },
                formInquiry: {
                    bank: "",
                    account_number: ""
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
                }
            }
        },

        mounted() {
            this.getDataProject()
            this.getDataBank()
            this.getDataCompany()
        },
        methods: {
            async submitProcess() {
                try {
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/transaction', this.formData)
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
                            this.$router.push(`/app/transaction/${respSave.data.id}/detail`);
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
                        position: 'top-end',
                        icon: 'error',
                        title: "Please fill title and amount",
                        showConfirmButton: false,
                        timer: 1500
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
                    this.$vs.loading()
                    const respSave = await this.$axios.post('api/inquiry', this.formInquiry)
                    this.$vs.loading.close()
                    if (!respSave.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respSave.message,
                            showConfirmButton: false,
                            timer: 1500
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
                            await this.getData()
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
            async getDataCompany() {
                try {
                    this.$vs.loading()
                    const respCompany = await this.$axios.get(`api/company/${this.$route.params.id}/detail`)
                    this.$vs.loading.close()
                    if (!respCompany.status) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: respCompany.message,
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return
                    }
                    this.company = respCompany.data
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
            async getDataInquiry() {
                try {
                    this.$vs.loading()
                    this.inquiries = await this.$axios.get(`api/inquiry?bank=${this.formData.bank}`)
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
            async getDataProject() {
                try {
                    this.$vs.loading()
                    this.projects = await this.$axios.get(`api/project?company_id=${this.$route.params.id}`)
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
