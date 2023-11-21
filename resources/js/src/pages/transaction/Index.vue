<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Transaction List</h1>
            </div>
            <div class="row ml-3">
                <!--<div class="col-md-3">-->
                    <!--<div class="input-group mb-2">-->
                        <!--<div class="input-group-prepend">-->
                            <!--<div class="input-group-text">Title</div>-->
                        <!--</div>-->
                        <!--<input type="text" class="form-control" id="title" placeholder="Title" v-model="sortVal.title">-->
                    <!--</div>-->
                <!--</div>-->
                <!--<div class="col-md-3">-->
                    <!--<div class="input-group mb-2">-->
                        <!--<div class="input-group-prepend">-->
                            <!--<div class="input-group-text">Status</div>-->
                        <!--</div>-->
                        <!--<select name="status" v-model="sortVal.status" class="form-control">-->
                            <!--<option value="active" :selected="sortVal.status== null ? true : false">All</option>-->
                            <!--<option value="active" :selected="sortVal.status== 'active' ? true : false">Active</option>-->
                            <!--<option value="not_active" :selected="sortVal.status== 'not_active' ? true : false">Not Active</option>-->
                        <!--</select>-->
                    <!--</div>-->
                <!--</div>-->
                <div class="col-md-3">
                    <!--<button class="btn btn-success mb-2" @click="sortValue()">Search</button>-->
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>Transaction Number</th>
                            <th>Author</th>
                            <th>Company</th>
                            <th>Method</th>
                            <th>Project</th>
                            <th>Title</th>
                            <th>Last Status</th>
                            <th>Total</th>
                            <th>Created At</th>
                            <th>Approval</th>
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
                                <span class="badge  rounded-pill text-bg-primary">{{ transaction.method ?? "-" }}</span>
                            </td>
                            <td><span class="badge  rounded-pill text-bg-warning">{{ transaction.project.title }}</span></td>
                            <td>{{ transaction.title }}</td>
                            <td>
                                <span :class="transaction.current_status | labelByStatus">
                                    {{ transaction.current_status}}
                                </span>
                            </td>
                            <td>Rp. {{ transaction.total_amount | formatPriceWithDecimal }}</td>
                            <td>{{ transaction.created_at | formatDate }}</td>
                            <td>
                                <div class="avatar-stack">
                                    <span v-if="transaction.current_status !== 'rejected'" v-for="(approval, index) in transaction.transaction_approval_nulls" :key="index"
                                          class="avatar"  data-toggle="tooltip" data-placement="top" :title="approval.user.name">
                                        {{ approval.user.name | getShortName }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--<div class="justify-content-center d-flex">-->
                        <!--<pagination v-model="page" :records="totalData" :per-page="perPage" @paginate="getData"/>-->
                    <!--</div>-->
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
                }
            }
        },
        created() {
            this.getData()
            console.log("permissions", this.$store.state.permissions)
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.transactions = await this.$axios.get('api/transaction')
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