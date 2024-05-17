<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title d-flex justify-content-between">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Company List</h1>
                <router-link to="/backend/app/create/form">
                    <button class="btn btn-primary mr-3 mt-3" type="button">
                        <i class="fas fa-plus-circle"></i>
                    </button>
                </router-link>
            </div>
            <div class="row ml-3">
                <div class="col-xl-3">
                    <!--<div class="input-group mb-2">-->
                        <!--<div class="input-group-prepend">-->
                            <!--<div class="input-group-text">Transaction Number</div>-->
                        <!--</div>-->
                        <!--<input type="text" class="form-control" id="title" placeholder="Transaction Number" v-model="formFilter.transaction_number">-->
                    <!--</div>-->
                </div>
                <div class="col-xl-3">
                    <!--<div v-if="!['staff', 'admin'].includes($store.state.role)" class="input-group mb-2">-->
                        <!--<div class="input-group-prepend">-->
                            <!--<div class="input-group-text">Status</div>-->
                        <!--</div>-->
                        <!--<select name="status" v-model="formFilter.status" class="form-control">-->
                            <!--<option value="">All Status</option>-->
                            <!--<option value="published">Published</option>-->
                            <!--<option value="processed">Processed</option>-->
                            <!--<option value="completed">Completed</option>-->
                        <!--</select>-->
                    <!--</div>-->
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
                            <th class="text-center">Is Whitelist</th>
                            <th class="text-center">Domain</th>
                            <th class="text-center">Is Multiple Company</th>
                            <th class="text-center">Created At</th>
                            <th class="text-center">#</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(app, index) in apps" :key="index">
                            <td>{{ app.is_whitelist ? 'Yes' : 'No' }}</td>
                            <td>{{ app.domain ?? '-' }}</td>
                            <td>{{ app.is_multiple_company ? 'Yes' : 'No' }}</td>
                            <td>{{ app.created_at | formatDate }}</td>
                            <td class="text-right">
                                <router-link :to="'/backend/app/'+app.id+'/form'">
                                    <button type="button" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt"></i>
                                    </button>
                                </router-link>
                                <router-link :to="'/backend/app/'+app.id+'/detail'">
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
                apps: [],
                formData: {
                    id: "",
                    title: "",
                    voucherPrefix: "",
                    type: ""
                },
                formFilter: {
                    // transaction_number: '',
                    // status: ''
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
                    const transLocal = await this.$axios.get(`api/backend/app?page=${this.page}&` + new URLSearchParams(this.formFilter).toString())
                    this.apps = transLocal.data
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