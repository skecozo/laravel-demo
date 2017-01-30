import Vue from 'vue';
import Vuex from 'vuex';
import * as actions from './actions.js';
import * as mutations from './mutations.js';
import * as getters from './getters.js';
import routes from '../routes.js';

Vue.use(Vuex);

export const state = {
    userInfo: '',
    serachdata:{}
};

export default new Vuex.Store({
    state,
    actions,
    mutations,
    getters
});
