<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('auth/user', 'AuthController@user');
    Route::post('auth/logout', 'AuthController@logout');
    Route::post('auth/password', 'AuthController@password');
});

Route::group(['middleware' => 'jwt.refresh'], function () {
    Route::get('auth/refresh', 'AuthController@refresh');
});

Route::prefix('auth')->group(function () {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
});

Route::prefix('profile')->group(function () {
    Route::get('/', 'ProfileController@profile');
    Route::put('/', 'ProfileController@putProfile');
    Route::post('/avatar', 'ProfileController@putAvatar');
    Route::post('/withdraw', 'ProfileController@withdraw');
    Route::get('/withdraws', 'ProfileController@getWithdraw');
});

Route::prefix('notifications')->group(function () {
    Route::post('/', 'NotificationsController@get');
    Route::post('/has_new', 'NotificationsController@hasNew');
});

Route::prefix('projects')->group(function () {
    Route::post('/', 'ProjectsController@list');
    Route::put('/create', 'ProjectsController@createProject');
    Route::get('/{project}', 'ProjectsController@getInfo');
    Route::get('/{project}/take', 'ProjectsController@takeProject');
    Route::get('/{project}/contacts', 'ProjectsController@getProjectContacts');
    Route::put('/add_contact', 'ProjectsController@updateProjectContacts');
    Route::get('/{project}/contacts/{contact}/remove', 'ProjectsController@removeProjectContact');
    Route::post('/{project}/contacts/{contactId}', 'ProjectsController@saveProjectContact');
    Route::post('/create_invoice', 'ProjectsController@createInvoice');
    Route::post('/invoices', 'ProjectsController@invoices');
    Route::post('/invoice/url', 'ProjectsController@invoiceUrl');
    Route::post('/contacts', 'ProjectsController@contacts');
});

Route::prefix('taxonomy')->group(function () {
    Route::get('/fields', 'TaxonomyController@fields');
    Route::get('/regions', 'TaxonomyController@regions');
    Route::get('/contact_statuses', 'TaxonomyController@contactStatuses');
    Route::get('/work_experience', 'TaxonomyController@workExperience');
    Route::get('/field_categories', 'TaxonomyController@fieldsCategories');
});

Route::prefix('calls')->group(function () {
    Route::post('/requestContact', 'CallsController@requestContact');
    Route::post('/callContact', 'CallsController@callContact');
    Route::post('/callResultRecall', 'CallsController@callResultRecall');
    Route::post('/callResultLead', 'CallsController@callResultLead');
    Route::post('/callResultReject', 'CallsController@callResultReject');
    Route::post('/getCallResults', 'CallsController@getCallResults');
    Route::post('/getContact', 'CallsController@getContact');
});

Route::post('/support/add', 'SupportController@add');
