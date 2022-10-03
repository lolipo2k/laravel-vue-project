/**
 * Получить информацию о текущем профиле (то-же что $auth.user()
 * @param state
 * @returns {*}
 */
export function user(state) {
    return state.user;
}

/**
 * Пока те-же данные что и user геттер. Но в будущем может измениться
 * @param state
 * @returns {*}
 */
export function profile(state) {
    return state.user;
}

export function profileFilled(state) {
    return !!(state.user && state.user.fields && state.user.fields.length);
}

export function userInvoices(state) {
    return state.invoices;
}
