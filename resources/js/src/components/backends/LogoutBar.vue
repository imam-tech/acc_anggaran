<template>
    <div class="d-flex justify-content-between">
        <router-link class="dropdown-item text-center" to="#">
            <img src="https://png.pngtree.com/png-vector/20190114/ourlarge/pngtree-vector-avatar-icon-png-image_313572.jpg" style="width:40px" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <h6>{{this.$store.state.admin_email.substring(0,12)+ '...'}}</h6>
        </router-link>
        <button class="btn btn-warning m-4 d-flex justify-content-center align-items-center" @click="confirmLogout()">
            <i class="fas fa-sign-out-alt fa-sm fa-fw text-gray-400"></i>Logout
        </button>
    </div>
</template>

<script>

    import Cookies from 'js-cookie'

    export default {
        data() {
            return {
                'data' : {}
            }
        },
        methods: {
            async confirmLogout() {
                let hasLogin = confirm('Are you sure you want to logout (backend)?')
                if( hasLogin) {
                    this.$store.commit('SET_ADMIN_USER', {
                        admin_email: '',
                        admin_name: '',
                        isLogin: false
                    })
                    await this.$axios.get(`api/backend/auth/logout`)
                    Cookies.remove('access_token_backend_fat')
                    return window.location.href = '/backend/auth/login'
                }
            }
        }

    }
</script>


