/**
 *
 * @return { string }
 */
export function projects(state) {
    return state.list;
}

export function selected(state) {
    return state.selectedProject;
}

export function callResults(state) {
    return state.callResults;
}
