/**
 * @param { function } commit
 * @param { string } data
 */
import {fetchData, prepareUrl, putData} from "../helpers";
import {
    PROFILE_PUT,
    PROJECT_TAKE,
    PROJECTS_INFO,
    PROJECTS_LIST,
    PROJECTS_TAKE,
    PROJECT_ADD_NEW,
    PROJECT_STOP,
    LEAD_ACCEPT,
    LEAD_REJECT,
    PROJECT_CREATE_INVOICE,
    PROJECT_ADD_INVOICE,
    REQUEST_CONTACT,
    TAXONOMY_REGIONS,
    CALL_RESULTS,
    CALL_CONTACT,
    RESULT_RECALL,
    RESULT_LEAD,
    RESULT_REJECT,
    PROFILE_PUT_AVATAR,
    PUT_BASE_FILE, PUT_SINGLE_CONTACT
} from "../../back-routes";

export function set({commit}, {data}) {
}

/**
 * Получить список проектов
 * @param commit
 * @param userOnly false - все, true - только проекты пользователя
 * @param page номер страницы
 * @param perPage элементов на страницы
 * @param search строка для поиска в названии
 * @param filter фильтрация: all - все, free - свободные, taken - занятые
 * @param orderBy поле для сортировки (по умолчанию id)
 */
export function fetchList(context, {
    userOnly = false,
    page = 1,
    perPage = 500,
    search = '',
    filter = 'all',
    orderBy = 'id',
    includeArchived = false,
} = {}) {
    return fetchData(this.$axios,
        context,
        PROJECTS_LIST,
        {
            userOnly,
            page,
            perPage,
            search,
            filter,
            orderBy,
            includeArchived
        },
        'setList'
    )
}


export function fetchProject(context, projectId) {
    return fetchData(this.$axios,
        context,
        prepareUrl(PROJECTS_INFO, {
            'project': projectId
        }),
        null,
        'setSelected'
    )
}

export function fetchCallResults(context, payload) {
    return fetchData(this.$axios,
        context,
        CALL_RESULTS,
        payload,
        'setCallResults'
    )
}

export function loadNextNumber(context, projectId) {
    return fetchData(
        this.$axios,
        context,
        REQUEST_CONTACT,
        {
            'project_id': projectId
        },
        'setCurrentNumber'
    )
}

export function callContact (context, payload) {
    return fetchData(
        this.$axios,
        context,
        CALL_CONTACT,
        payload,
        null
    )
}
export function setRecall (context, payload) {
    return fetchData(
        this.$axios,
        context,
        RESULT_RECALL,
        payload,
        null
    )
}

export function setLead (context, payload) {
    return fetchData(
        this.$axios,
        context,
        RESULT_LEAD,
        payload,
        null
    )
}
export function setReject (context, payload) {
    return fetchData(
        this.$axios,
        context,
        RESULT_REJECT,
        payload,
        null
    )
}


export function takeProject(context, projectId) {
    return fetchData(this.$axios,
        context,
        PROJECTS_TAKE.replace('{project}', projectId),
    )
}


export function putProject(context, project) {
    return putData(this.$axios,
        context,
        PROJECT_ADD_NEW,
        project);
}

export function createInvoice(context, payload) {
    return fetchData(this.$axios,
        context,
        PROJECT_CREATE_INVOICE,
        payload);
}


export function stopProject(context, project) {
    return putData(this.$axios,
        context,
        PROJECT_STOP,
        project);
}

export function acceptLead(context, lead) {
    return putData(this.$axios,
        context,
        LEAD_ACCEPT,
        lead);
}
export function rejectLead(context, lead) {
    return putData(this.$axios,
        context,
        LEAD_REJECT,
        lead);
}


export function putBaseFile(context, file) {
    const config = {
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    };

    let data = new FormData();

    data.append('file', file);

    return axios.post(PUT_BASE_FILE, data, config)
}

export function addSingleContact(context, contact) {
    return putData(this.$axios,
        context,
        PUT_SINGLE_CONTACT,
        contact);
}
