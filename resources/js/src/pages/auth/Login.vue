<template>
    <div class="container h-100">
        <div class="d-flex align-items-center justify-content-center">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
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
                    <!--<hr>-->
                    <!--<div class="text-center">-->
                        <!--<a class="small" href="#">Forgot Password?</a>-->
                    <!--</div>-->
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
                    const responseLogin = await this.$axios.post(`api/auth/login`, this.formData)
                    console.log("resp", responseLogin);
                    this.$vs.loading.close()
                    if (responseLogin.status) {
                        Swal.fire({
                            position: 'top',
                            icon: 'success',
                            title: "success",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(()=>{
                            this.$store.commit('SET_USER', {
                                'app': responseLogin.data.user.app,
                                'email' : responseLogin.data.user.email,
                                'name' : responseLogin.data.user.name,
                                'permissions' : responseLogin.data.permissions,
                                'role' : responseLogin.data.role,
                                'signAt': responseLogin.data.sign_at,
                                'isLogin': true
                            })
                            Cookies.set('access_token_fat', responseLogin.data.token, { expires: 1 })
                            this.$router.push('/app');
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