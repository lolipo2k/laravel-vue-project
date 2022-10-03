/**
 * @param axios
 * @param context
 * @param url
 * @param params
 * @param mutation
 * @param headers
 * @returns {Promise<unknown>}
 */
export const putData = (axios, context, url, params, mutation = false, headers = {}) => {
    return new Promise((resolve, reject) => {
        axios.put(url, params, headers)
            .then(response => response.data)
            .then(data => {
                if (mutation) {
                    context.commit(mutation, data);
                }
                // store.$Progress.finish();
                resolve(data);
            })
            .catch(error => {
                // store.$Progress.fail();
                context.dispatch('error', error, {root: true});
                reject(error);
            });
    })
};

/**
 * Fetch data from backend
 * @param axios
 * @param context
 * @param url
 * @param params
 * @param mutation
 * @param headers
 * @returns {Promise<unknown>}
 */
export const fetchData = async (axios,
                                context,
                                url,
                                params,
                                mutation = false,
                                headers = {},
                                mutator = null) => {

    const processResponse = (data, resolve) => {
        if (mutator) {
            data = mutator(data);
        }

        if (mutation) {
            context.commit(mutation, data);
        }
        // store.$Progress.finish();
        resolve(data);
    };

    return new Promise((resolve, reject) => {
        ((params) ? axios.post(url, params, headers) : axios.get(url))
            .then(response => response.data)
            .then(data => {
                return processResponse(data, resolve)
            })
            .catch(error => {
                context.dispatch('error', error, {root: true});
                reject(error);
            })
    })
};

export const prepareUrl = (url, params) => {
    _.forEach(params, (value, key) => {
        url = url.replace(`{${key}}`, value)
    });

    return url;
};