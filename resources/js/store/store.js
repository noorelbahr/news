import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {
        token: localStorage.getItem('token') || '',
        name: localStorage.getItem('name') || ''
    },
    mutations: {
        setName(state, name) {
            localStorage.setItem('name', name);
            state.name = name;
        },
        setToken(state, token) {
            localStorage.setItem('token', token);
            state.token = token;
        },
        clearToken(state) {
            localStorage.removeItem('token');
            state.token = '';
            state.name = '';
        }
    }
});
