<template>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="sidebar-brand-text mx-3">FAT System</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <router-link class="nav-link" :class="handleBgMenu('dashboard')" to="/app">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" :class="handleBgMenu('transaction')" to="/app/transaction">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaction</span>
            </router-link>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="handleShowMenu('configuration').col" href="#" data-toggle="collapse" data-target="#collapseConfig"
               aria-expanded="true" aria-controls="collapseConfig">
                <i class="fas fa-gear"></i>
                <span>Configuration</span>
            </a>
            <div id="collapseConfig" class="collapse" :class="handleShowMenu('configuration').bg" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/configuration/company">
                        <i class="fas fa-building"></i><span class="ml-2">Company</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/configuration/project">
                        <i class="fas fa-project-diagram"></i><span class="ml-2">Project</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/configuration/user">
                        <i class="fas fa-user"></i><span class="ml-2">User</span>
                    </router-link>
                    <router-link v-if="$store.state.permissions.includes('transaction_push_plugin')" class="collapse-item" to="/app/configuration/flip">
                        <i class="fas fa-money-bill"></i><span class="ml-2">Flip</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/configuration/role">
                        <i class="fas fa-user-circle"></i><span class="ml-2">Role</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/configuration/permission">
                        <i class="fas fa-lock"></i><span class="ml-2">Permission</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item bg-warning rounded">
            <select class="nav-link text-dark font-weight-bold" @change="changeCompany">
                <option v-for="(company, cI) in companies" :value="company.id" :key="cI" :selected="currentCompany == company.id">{{ company.title }}</option>
            </select>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="handleShowMenu('output-data').col" href="#" data-toggle="collapse" data-target="#collapseOutputData"
               aria-expanded="true" aria-controls="collapseOutputData">
                <i class="fas fa-upload"></i>
                <span>Output Data</span>
            </a>
            <div id="collapseOutputData" class="collapse" :class="handleShowMenu('output-data').bg" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/output-data/business-overview">
                        <i class="fas fa-chart-area"></i><span class="ml-2">Business Overview</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/output-data/report">
                        <i class="fas fa-file-archive"></i><span class="ml-2">Report</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="handleShowMenu('input-data').col" href="#" data-toggle="collapse" data-target="#collapseInputData"
               aria-expanded="true" aria-controls="collapseInputData">
                <i class="fas fa-download"></i>
                <span>Input Data</span>
            </a>
            <div id="collapseInputData" class="collapse" :class="handleShowMenu('input-data').bg" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/input-data/cash-and-bank">
                        <i class="fas fa-university"></i><span class="ml-2">Cash & Bank</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/input-data/sales">
                        <i class="fas fa-cart-plus"></i><span class="ml-2">Sales Invoice</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/input-data/purchase">
                        <i class="fas fa-shopping-cart"></i><span class="ml-2">Purchase Bill</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/input-data/journal">
                        <i class="fas fa-list-ul"></i><span class="ml-2">Journal</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="handleShowMenu('master-data').col" href="#" data-toggle="collapse" data-target="#collapseMasterData"
               aria-expanded="true" aria-controls="collapseMasterData">
                <i class="fas fa-database"></i>
                <span>Master Data</span>
            </a>
            <div id="collapseMasterData" class="collapse" :class="handleShowMenu('master-data').bg" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/master-data/contact">
                        <i class="fas fa-user-circle"></i><span class="ml-2">Contact</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/master-data/product">
                        <i class="fas fa-box"></i><span class="ml-2">Product</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/master-data/product/category">
                        <i class="fas fa-list-alt"></i><span class="ml-2">Product Category</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/master-data/unit">
                        <i class="fas fa-calculator"></i><span class="ml-2">Unit</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/master-data/payment-method">
                        <i class="fas fa-credit-card"></i><span class="ml-2">Payment Method</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/master-data/tag">
                        <i class="fas fa-tags"></i><span class="ml-2">Tag</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/master-data/taxes">
                        <i class="fas fa-balance-scale"></i><span class="ml-2">Taxes</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/master-data/coa">
                        <i class="fas fa-chair"></i><span class="ml-2">Chart of Account</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" :class="handleShowMenu('manufacture').col" href="#" data-toggle="collapse" data-target="#collapseManufacture"
               aria-expanded="true" aria-controls="collapseManufacture">
                <i class="fas fa-tractor"></i>
                <span>Manufacture</span>
            </a>
            <div id="collapseManufacture" class="collapse" :class="handleShowMenu('manufacture').bg" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/manufacture/product">
                        <i class="fas fa-check-double"></i><span class="ml-2">Finished Goods</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/manufacture/semi-finished-material">
                        <i class="fas fa-check"></i><span class="ml-2">Semi Finished Goods</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/manufacture/material">
                        <i class="fas fa-industry"></i><span class="ml-2">Material</span>
                    </router-link>
                </div>
            </div>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">

        <!-- Sidebar Toggler (Sidebar) -->
        <div class="text-center d-none d-md-inline mb-5">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
        </div>

    </ul>
</template>

<script>
    import Cookies from 'js-cookie'
    export default {
        name: 'Navbar',
        data() {
            return {
                companies: [],
                currentCompany: Cookies.get('current_company_fat')
            }
        },
        created() {
            this.getData()
        },
        methods: {
            handleBgMenu(menu) {
                return this.$route.name.includes(menu) ? 'bg-success rounded text-dark' : '';
            },

            handleShowMenu(menu) {
                return this.$route.name.includes(menu) ? {'bg': 'show', 'col': ''} : {'bg': '', 'col': 'collapsed'};
            },

            changeCompany(e) {
                const comp = this.companies.find((x) => x.id == e.target.value)
                Cookies.set('current_company_fat', comp.id, { expires: 1 })
                Cookies.set('current_company_title_fat', comp.title, { expires: 1 })
                window.location.reload();
            },
            async getData() {
                try {
                    this.$vs.loading()
                    this.companies = await this.$axios.get('api/configuration/company')
                    this.$vs.loading.close()
                    if (this.companies.length > 0) {
                        if (this.$route.query.is_default !== undefined) {
                            Cookies.set('current_company_fat', this.companies[this.companies.length-1].id, {expires: 1})
                            Cookies.set('current_company_title_fat', this.companies[this.companies.length-1].title, {expires: 1})
                            this.currentCompany = Cookies.get('current_company_fat')
                        }
                        if (!Cookies.get("current_company_fat")) {
                            Cookies.set('current_company_fat', this.companies[0].id, {expires: 1})
                        }
                        if (!Cookies.get("current_company_title_fat")) {
                            Cookies.set('current_company_title_fat', this.companies[0].title, {expires: 1})
                        }
                    } else {
                        if (this.$store.state.roles === 'administrator') {
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: 'Please create a company first to use this platform',
                                showConfirmButton: false,
                                timer: 3000
                            }).then(async () => {
                                this.$router.push('/app/configuration/company?show_create=yes')
                            })
                        } else {
                            Swal.fire({
                                position: 'top',
                                icon: 'error',
                                title: "You don't have any company to use this platform, please tell your administrator.",
                                showConfirmButton: false,
                                timer: 3000
                            }).then(async () => {
                                this.$router.push('/app')
                            })
                        }
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
        }
    }
</script>