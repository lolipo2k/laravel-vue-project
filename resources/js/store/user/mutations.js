export default {
    /**
     * @param { object } state
     * @param { object } user
     */
    set(state, user) {
        state.user = user;
        state.profile = user;
    },

    setInvoices(state, invoices) {
        state.invoices = invoices;
    },
};
