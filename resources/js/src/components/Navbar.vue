<template>
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">FAT System</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item">
            <router-link class="nav-link" to="/app">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/transaction">
                <i class="fas fa-exchange-alt"></i>
                <span>Transaction</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/company">
                <i class="fas fa-building"></i>
                <span>Company</span>
            </router-link>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/user">
                <i class="fas fa-user"></i>
                <span>User</span>
            </router-link>
        </li>
        <li v-if="$store.state.permissions.includes('transaction_push_plugin')" class="nav-item">
            <router-link class="nav-link" to="/app/setting">
                <i class="fas fa-gear"></i>
                <span>Setting</span>
            </router-link>
        </li>
        <li class="nav-item bg-warning rounded">
            <select class="nav-link text-dark font-weight-bold" @change="changeCompany">
                <option v-for="(company, cI) in companies" :value="company.id" :key="cI" :selected="currentCompany == company.id">{{ company.title }}</option>
            </select>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/cash-and-bank">
                <i class="fas fa-university"></i>
                <span>Cash & Bank</span>
            </router-link>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
               aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-cart-plus"></i>
                <span>Sales</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/sales">
                        <span>Sales Invoice</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/sales/customer">
                        <span>Customer</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePurchase"
               aria-expanded="true" aria-controls="collapsePurchase">
                <i class="fas fa-clipboard-list"></i>
                <span>Purchase</span>
            </a>
            <div id="collapsePurchase" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/purchase">
                        <span>Purchase Bill</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/purchase/supplier">
                        <span>Supplier</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInventory"
               aria-expanded="true" aria-controls="collapseInventory">
                <i class="fas fa-box"></i>
                <span>Product</span>
            </a>
            <div id="collapseInventory" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/product">
                        <span>List</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/product/category">
                        <span>Category</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/product/unit">
                        <span>Unit</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseManufacture"
               aria-expanded="true" aria-controls="collapseManufacture">
                <i class="fas fa-tractor"></i>
                <span>Manufacture</span>
            </a>
            <div id="collapseManufacture" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/manufacture/product">
                        <span>Products</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/manufacture/semi-finished-material">
                        <span>Semi Finished Material</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/manufacture/material">
                        <span>Material</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/budget">
                <i class="fas fa-money-bill"></i>
                <span>Budget</span>
            </router-link>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAccounting"
               aria-expanded="true" aria-controls="collapseAccounting">
                <i class="fas fa-dollar-sign"></i>
                <span>Accounting</span>
            </a>
            <div id="collapseAccounting" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <router-link class="collapse-item" to="/app/journal">
                        <span>Journal</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/coa">
                        <span>Chart of Account</span>
                    </router-link>
                    <router-link class="collapse-item" to="/app/tax">
                        <span>Tax</span>
                    </router-link>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <router-link class="nav-link" to="/app/report">
                <i class="fas fa-newspaper"></i>
                <span>Report</span>
            </router-link>
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
                currentCompany: Cookies.get('current_company')
            }
        },
        created() {
            this.getData()
        },
        methods: {
            changeCompany(e) {
                const comp = this.companies.find((x) => x.id == e.target.value)
                Cookies.set('current_company', comp.id, { expires: 1 })
                Cookies.set('current_company_title', comp.title, { expires: 1 })
                window.location.reload();
            },
            async getData() {
                try {

                    this.$vs.loading()
                    this.companies = await this.$axios.get('api/company')
                    this.$vs.loading.close()
                    if (this.companies.length > 0) {
                        if (!Cookies.get("current_company")) {
                            Cookies.set('current_company', this.companies[0].id, {expires: 1})
                        }
                        if (!Cookies.get("current_company_title")) {
                            Cookies.set('current_company_title', this.companies[0].title, {expires: 1})
                        }
                    } else {
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: 'Please create a company first to use this platform',
                            showConfirmButton: false,
                            timer: 3000
                        }).then(async ()=>{
                            this.$router.push('/app/company/')
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
        }
    }
</script>