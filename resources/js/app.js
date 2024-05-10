import Vue from 'vue'
import router from './src/routers/router.js'
import App from './src/App.vue'
import store from './src/store/store.js'
import vSelect from 'vue-select'
import './src/plugins/axios.js'
import './src/plugins/vuesax.js'
import './src/plugins/filter.js'
import 'vue-select/dist/vue-select.css';
import Pagination from 'vue-pagination-2';
import Swal from 'sweetalert2'
import 'sweetalert2/src/sweetalert2.scss'

Vue.component('v-select', vSelect)
Vue.component('pagination', Pagination);

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')