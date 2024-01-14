<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title d-flex justify-content-between">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Transaction List</h1>
                <router-link to="/app/transaction/create/form">
                    <button class="btn btn-primary mr-3 mt-3" type="button">
                        <i class="fas fa-plus-circle"></i> Create a New Transaction
                    </button>
                </router-link>
            </div>
            <div class="row ml-3">
                <div class="col-xl-3">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Transaction Number</div>
                        </div>
                        <input type="text" class="form-control" id="title" placeholder="Transaction Number" v-model="formFilter.transaction_number">
                    </div>
                </div>
                <div class="col-xl-3">
                    <div v-if="!['staff', 'admin'].includes($store.state.role)" class="input-group mb-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Status</div>
                        </div>
                        <select name="status" v-model="formFilter.status" class="form-control">
                            <option value="">All Status</option>
                            <option value="published">Published</option>
                            <option value="processed">Processed</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </div>
                <div class="col-xl-6 text-right">
                    <button class="btn btn-success mb-2 mr-3" @click="handleGetData()">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Transaction Number</th>
                            <th class="text-center">Author</th>
                            <th class="text-center">Company</th>
                            <th class="text-center">Method</th>
                            <th class="text-center">Project</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Last Status</th>
                            <th class="text-center">Total</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">Approval</th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(transaction, index) in transactions" :key="index">
                            <td>
                                <router-link :to="'/app/transaction/'+transaction.id+'/detail'">
                                    {{ transaction.transaction_number }}
                                </router-link>
                            </td>
                            <td>{{ transaction.user_created_by.name }}</td>
                            <td>{{ transaction.project.company.title }}</td>
                            <td>
                                <span :class="transaction.method | methodByStatus">{{ transaction.method ?? "-" }}</span>
                            </td>
                            <td><span class="badge  rounded-pill text-bg-warning p-2">{{ transaction.project.title }}</span></td>
                            <td>{{ transaction.title }}</td>
                            <td>
                                <span :class="transaction.current_status | labelByStatus">
                                    {{ transaction.current_status}}
                                </span>
                            </td>
                            <td class="text-right">Rp. {{ transaction.total_amount | formatPriceWithDecimal }}</td>
                            <td>{{ transaction.created_at | formatDate }}</td>
                            <td>
                                <div class="avatar-stack">
                                    <span v-if="transaction.current_status !== 'rejected'" v-for="(approval, index) in transaction.transaction_approval_nulls" :key="index"
                                          class="avatar"  data-toggle="tooltip" data-placement="top" :title="approval.user.name">
                                        {{ approval.user.name | getShortName }}
                                    </span>
                                </div>
                            </td>
                            <td class="text-right">
                                <router-link :to="'/app/transaction/'+transaction.id+'/detail'">
                                    <button type="button" class="btn btn-info">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </router-link>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="11" class="text-end">
                                <pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="handleGetData"/>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Index.vue",
        data() {
            return {
                transactions: [],
                formData: {
                    id: "",
                    title: "",
                    voucherPrefix: "",
                    type: ""
                },
                formFilter: {
                    transaction_number: '',
                    status: ''
                },
                page: 1,
                totalData: 0,
                perPage: 0,
            }
        },
        created() {
            this.handleGetData()
        },
        methods: {
            async handleGetData() {
                try {
                    this.$vs.loading()
                    const transLocal = await this.$axios.get(`api/transaction?page=${this.page}&` + new URLSearchParams(this.formFilter).toString())
                    this.transactions = transLocal.data
                    this.totalData = transLocal.total
                    this.page = transLocal.current_page
                    this.perPage = transLocal.per_page
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
            }
        }
    }
</script>