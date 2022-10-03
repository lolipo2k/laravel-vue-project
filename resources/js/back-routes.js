export const AUTH_REGISTER = '/api/auth/register';
export const AUTH_LOGIN = '/api/auth/login';
export const AUTH_LOGOUT = '/api/auth/logout';
export const AUTH_USER = '/api/auth/user';
export const AUTH_RESET = '/api/auth/reset';
export const AUTH_REFRESH = '/api/auth/refresh';

export const PROFILE_FETCH = '/api/profile';
export const PROFILE_PUT = '/api/profile';
export const PROFILE_PASSWORD_PUT = '/api/profile/password';
export const PROFILE_PUT_AVATAR = '/api/profile/avatar';
export const PROFILE_INVOICES = '/api/projects/invoices';
export const URL_INVOICE = '/api/projects/invoice/url';
export const CONFIRM_PHONE = '/api/profile/confirm_phone';
export const WITHDRAW = '/api/profile/withdraw';

export const SUPPORT_SEND = '/api/support/add';


export const PROJECTS_LIST = '/api/projects';
export const PROJECTS_INFO = '/api/projects/{project}';
export const PROJECTS_TAKE = '/api/projects/{project}/take';
export const PROJECT_ADD_NEW = '/api/projects/create';
export const PROJECT_CREATE_INVOICE = '/api/projects/create_invoice';
export const PROJECT_STOP = '/api/projects/stop';

export const PUT_BASE_FILE = '/api/projects/contacts';
export const PUT_SINGLE_CONTACT = '/api/projects/add_contact';

export const CALL_RESULTS = '/api/calls/getCallResults';
export const REQUEST_CONTACT = '/api/calls/requestContact';
export const CALL_CONTACT = '/api/calls/callContact';
export const RESULT_RECALL = '/api/calls/callResultRecall';
export const RESULT_LEAD = '/api/calls/callResultLead';
export const RESULT_REJECT = '/api/calls/callResultReject';

export const LEAD_ACCEPT = '/api/projects/lead_accept';
export const LEAD_REJECT = '/api/projects/lead_reject';

export const PROJECT_CONTACTS = '/{project}/contacts';
export const PROJECT_CONTACTS_REMOVE = '/{project}/contacts/{contact}/remove';
export const PROJECT_CONTACTS_SAVE = '/{project}/contacts/{contactId}';

export const TAXONOMY_REGIONS = '/api/taxonomy/regions';
export const TAXONOMY_FIELDS = '/api/taxonomy/fields';
export const TAXONOMY_WORK_EXPERIENCE = '/api/taxonomy/work_experience';
export const TAXONOMY_CONTACT_STATUSES = '/api/taxonomy/contact_statuses';
export const TAXONOMY_FIELD_CATEGORIES = '/api/taxonomy/field_categories';
