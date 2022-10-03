/**
 * @param { function } commit
 * @param { function } dispatch
 * @param { object } state
 * @param {object} user
 */
import {fetchData, prepareUrl, putData} from "../helpers";
import {
    CONFIRM_PHONE,
    PROFILE_FETCH, PROFILE_INVOICES,
    PROFILE_PASSWORD_PUT,
    PROFILE_PUT,
    PROFILE_PUT_AVATAR,
    SUPPORT_SEND, TAXONOMY_FIELDS, URL_INVOICE, WITHDRAW
} from "../../back-routes";

export function set({commit, state, dispatch}, user) {

    if (state.user.id !== user.id) {
        commit('set', user);
        return dispatch('refreshProfile')
    } else {
        commit('set', user);
        return Promise.resolve(state.profile);
    }
}

export function refreshProfile(context) {
    return fetchData(this.$axios,
        context,
        PROFILE_FETCH,
        null
    ).then(data => {
        context.commit('set', data.data);
        return data;
    })
}

export function putProfile(context, profile) {
    return putData(this.$axios,
        context,
        PROFILE_PUT,
        profile);
}

export function putAvatar(context, avatarFile) {
    const config = {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    };

    let data = new FormData();

    data.append('file', avatarFile);

    return axios.post(PROFILE_PUT_AVATAR, data, config)
}

export function fetchInvoices(context) {
    return fetchData(
        this.$axios,
        context,
        PROFILE_INVOICES,
        {},
        'setInvoices'
    )
}

export function urlInvoices(context,payload) {
    return fetchData(
        this.$axios,
        context,
        URL_INVOICE,
        payload,
        'setInvoices'
    )
}

export function sendSupport(context, form) {
    return fetchData(this.$axios,
        context,
        SUPPORT_SEND,
        form
    )
}
export function callWithdraw(context, payload) {
    return fetchData(this.$axios,
        context,
        WITHDRAW,
        payload
    )
}

export function confirmPhone(context) {
    return fetchData(this.$axios,
        context,
        CONFIRM_PHONE,
    )
}

export function putNewPass(context, password) {
    return putData(this.$axios,
        context,
        PROFILE_PASSWORD_PUT,
        password);
}
