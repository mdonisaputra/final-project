import axios from 'axios';

export default{
    namespaced: true,
    state: {
        token: '',
        user: {},
    },
    mutations: {
        setToken: (state, payload) => {
            state.token = payload
        },
        setUser: (state, payload) => {
            state.user = payload
        },
    },
    actions: {
        setToken: ({commit,dispatch}, payload) => {
            commit('setToken', payload)
            // dispatch('checkToken', payload)

        },
        setUser: ({commit,dispatch}, payload) => {
            commit('setUser', payload)
            // dispatch('checkToken', payload)

        },
        // checkToken: ({commit}, payload) => {
        //     let config = {
        //         method: "post",
        //         url: "http://project-webservice.herokuapp.com/api/auth/login",
        //         // url: 'http://project-webservice.herokuapp.com/api/v2/auth/me',
        //         headers: {
        //             'Authorization': 'Bearer' + payload,
        //         },
        //     }
        // // setUser: ({commit}, payload) => {
        // //     commit('setUser', payload)
        // // },
        
        // axios(config)
        //     .then((response) => {
        //         commit('setUser', response.data)
        //     })
        //     // .catch(() => {
        //     //     commit('setUser', {})
        //     //     commit('setToken', '')
        //     // })
        // },
    },
    getters: {

        user: state => { return state.user},
        token: state => {return state.token},
        guest: state => Object.keys(state.user).length === 0,
    }
}