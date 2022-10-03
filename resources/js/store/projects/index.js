import * as actions from './actions';
import * as mutations from './mutations';
import * as getters from './getters';
import state from './state';

export default {
    namespaced: true,
    mutations,
    actions,
    state,
    getters,
};
