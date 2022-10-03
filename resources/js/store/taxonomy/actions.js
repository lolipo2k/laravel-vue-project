import {fetchData} from "../helpers";
import {
    TAXONOMY_CONTACT_STATUSES,
    TAXONOMY_FIELD_CATEGORIES,
    TAXONOMY_FIELDS,
    TAXONOMY_REGIONS,
    TAXONOMY_WORK_EXPERIENCE
} from "../../back-routes";

export function fetchFields(context) {
    return fetchData(
        this.$axios,
        context,
        TAXONOMY_FIELDS,
        null,
        'setFields'
    )
}

export function fetchRegions(context) {
    return fetchData(
        this.$axios,
        context,
        TAXONOMY_REGIONS,
        null,
        'setRegions'
    )
}
export function fetchFieldCategories(context) {
    return fetchData(
        this.$axios,
        context,
        TAXONOMY_FIELD_CATEGORIES,
        null,
        'setFieldCategories'
    )
}

export function fetchWorkExperience(context) {
    return fetchData(
        this.$axios,
        context,
        TAXONOMY_WORK_EXPERIENCE,
        null,
        'setWorkExperience'
    )
}

export function fetchContactStatuses(context) {
    return fetchData(
        this.$axios,
        context,
        TAXONOMY_CONTACT_STATUSES,
        null,
        'setContactStatuses'
    )
}
