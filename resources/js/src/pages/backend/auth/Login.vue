<template>
    <div class="container h-100">
        <div class="d-flex align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Welcome Back Admin!</h1>
                    </div>
                    <form class="user">
                        <div class="form-group">
                            <input v-model="formData.email" type="email" class="form-control"
                                id="exampleInputEmail" aria-describedby="emailHelp"
                                placeholder="Enter Email Address...">
                        </div>
                        <div class="form-group d-flex flex-row">
                            <input v-model="formData.password" :type="showPassword ? 'text' : 'password'" class="form-control"
                                id="exampleInputPassword" placeholder="Password">
                            <button type="button" class="btn btn-info" @click="showPassword = !showPassword">
                                <i v-if="!showPassword" class="fas fa-eye"></i>
                                <i v-else class="fas fa-eye-slash"></i>
                            </button>
                        </div>
                        <button type="button" @click="loginProcess()" class="btn btn-primary btn-user btn-block">
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Cookies from "js-cookie";

    export default {
        name: "Login.vue",
        data() {
            return {
                formData: {
                    email: "",
                    password: ""
                },
                showPassword: false
            }
        },
        mounted() {
            console.log("store", this.$store.state)
        },
        methods: {
            async loginProcess() {
                try {
                    this.$vs.loading();
                    const responseLogin = await this.$axios.post(`api/backend/auth/login`, this.formData)
                    this.$vs.loading.close()
                    if (responseLogin.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>{
                            this.$store.commit('SET_ADMIN_USER', {
                                'admin_email' : responseLogin.data.admin_user.email,
                                'admin_name' : responseLogin.data.admin_user.name,
                                'isLogin': true
                            })
                            Cookies.set('access_token_backend_fat', responseLogin.data.token, { expires: 1 })
                            return window.location.href = '/backend'
                        })
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: responseLogin.message,
                            showConfirmButton: false,
                            timer: 1500
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