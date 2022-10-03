<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
   // return redirect('/home/register');
    return view('welcome');
});

Route::get('/recrut', function () {
    // return redirect('/home/register');
    return view('recrut');
});


Route::get('/cookie', function () {
    return view('cookie');
});

Route::get('/policy', function () {
    return view('policy');
});

Route::get('/terms', function () {
    return view('terms');
});
Route::get('/terms-recrut', function () {
    return view('terms-recrut');
});

Route::get('/home', 'HomeController@spa');
Route::get('/home/{any}', 'HomeController@spa')->where('any', '.*');

Auth::routes(['register' => false]);
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('reset');

Route::post('/controlpanel/withdraws/confirm', 'WithdrawAdminController@confirm');
Route::post('/controlpanel/withdraws/cancel', 'WithdrawAdminController@cancel');

Route::post('/gate/yoomoney', 'PaymentController@gateYoomoney');


//Route::get('/home', 'HomeController@index')->name('home');
