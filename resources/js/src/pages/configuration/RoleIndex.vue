<template>
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-title">
                <h1 class="h3 mt-3 ml-3 text-gray-800 float-left">Role List</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th class="text-center">Title</th>
                            <th class="text-center">Displayed Title</th>
                            <th class="text-center">Permissions</th>
                            <th class="text-center">Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(role, index) in roles" :key="index">
                            <td>{{ role.title }}</td>
                            <td>{{ role.display_title }}</td>
                            <td>
                                <ul>
                                    <li v-for="(perm, permI) in role.role_permissions" :key="permI">
                                        {{ perm.permission.title }} | {{ perm.permission.display_title }}
                                    </li>
                                </ul>
                            </td>
                            <td>{{ role.created_at | formatDate }}</td>
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
                roles: []
            }
        },
        created() {
            if (!this.$store.state.permissions.includes('transaction_push_plugin')) {
                Swal.fire({
                    position: 'top',
                    icon: 'error',
                    title: 'You don\'t have an access this page',
                    showConfirmButton: false,
                    timer: 3000
                }).then(async ()=>{
                    this.$router.push('/app/')
                })
                return
            }
            this.getData()
        },
        methods: {
            async getData() {
                try {
                    this.$vs.loading()
                    this.roles = await this.$axios.get('api/configuration/role')
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