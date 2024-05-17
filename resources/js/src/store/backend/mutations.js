const mutations = {
    SET_ADMIN_USER (state, val) {
        state.isLogin = val.isLogin,
        state.admin_email = val.admin_email,
        state.admin_name = val.admin_name
    },
}
export default mutations
