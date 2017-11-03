import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        errors: [],
        success: false
    },
    mutations: {
        errors(state, errors) {
            state.errors = errors
        },
        success(state, success) {
            state.success = success
        }
    },
    actions: {}
})
