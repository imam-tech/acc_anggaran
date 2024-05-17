<template>
    <ul class="navbar-nav sidebar sidebar-dark accordion bg-gradient-danger" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Backend FAT</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <router-link class="nav-link" :class="handleBgMenu('dashboard')" to="/backend">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :class="handleBgMenu('transaction')" to="/backend/app">
                <i class="fas fa-exchange-alt"></i>
                <span>Company</span>
            </router-link>
        </li>
        <!--<li class="nav-item">-->
            <!--<a class="nav-link" :class="handleShowMenu('configuration').col" href="#" data-toggle="collapse" data-target="#collapseConfig"-->
               <!--aria-expanded="true" aria-controls="collapseConfig">-->
                <!--<i class="fas fa-gear"></i>-->
                <!--<span>Configuration</span>-->
            <!--</a>-->
            <!--<div id="collapseConfig" class="collapse" :class="handleShowMenu('configuration').bg" aria-labelledby="headingTwo" data-parent="#accordionSidebar">-->
                <!--<div class="bg-white py-2 collapse-inner rounded">-->
                    <!--<router-link class="collapse-item" to="/app/configuration/company">-->
                        <!--<i class="fas fa-building"></i><span class="ml-2">Company</span>-->
                    <!--</router-link>-->
                    <!--<router-link class="collapse-item" to="/app/configuration/project">-->
                        <!--<i class="fas fa-project-diagram"></i><span class="ml-2">Project</span>-->
                    <!--</router-link>-->
                    <!--<router-link class="collapse-item" to="/app/configuration/user">-->
                        <!--<i class="fas fa-user"></i><span class="ml-2">User</span>-->
                    <!--</router-link>-->
                    <!--<router-link v-if="$store.state.permissions.includes('transaction_push_plugin')" class="collapse-item" to="/app/configuration/flip">-->
                        <!--<i class="fas fa-money-bill"></i><span class="ml-2">Flip</span>-->
                    <!--</router-link>-->
                    <!--<router-link class="collapse-item" to="/app/configuration/role">-->
                        <!--<i class="fas fa-user-circle"></i><span class="ml-2">Role</span>-->
                    <!--</router-link>-->
                    <!--<router-link class="collapse-item" to="/app/configuration/permission">-->
                        <!--<i class="fas fa-lock"></i><span class="ml-2">Permission</span>-->
                    <!--</router-link>-->
                <!--</div>-->
            <!--</div>-->
        <!--</li>-->

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline mb-5">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
</template>

<script>
    export default {
        name: 'Navbar',
        data() {
            return {
            }
        },
        methods: {
            handleBgMenu(menu) {
                return this.$route.name.includes(menu) ? 'bg-success rounded text-dark' : '';
            },

            handleShowMenu(menu) {
                return this.$route.name.includes(menu) ? (window.innerWidth < 768 ? {'bg': '', 'col': 'collapsed'} : {'bg': 'show', 'col': ''}) : {'bg': '', 'col': 'collapsed'};
            },
        }
    }
</script>