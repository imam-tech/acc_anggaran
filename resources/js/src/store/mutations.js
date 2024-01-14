const mutations = {
    SET_USER (state, val) {
        state.app = val.app
        state.email = val.email
        state.name = val.name
        state.permissions = val.permissions
        state.role = val.role
        state.signAt = val.signAt
        state.isLogin = val.isLogin
    }
}
export default mutations
