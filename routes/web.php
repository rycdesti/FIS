<?php

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
    return redirect('/financial/account_category');
});

Route::group(['prefix' => '/financial'], function () {
//    Route::get('/account_category', 'FinancialManagement\AccountCategoryController@index');
    Route::resource('/account_category', 'Financial\AccountCategoryController');
    Route::get('/account_category/update_status/{account_category}', 'Financial\AccountCategoryController@update_status');

    Route::resource('/chart_account', 'Financial\ChartAccountController');
    Route::get('/chart_account/update_status/{chart_account}', 'Financial\ChartAccountController@update_status');
});

Route::group(['prefix' => '/ap'], function() {
    Route::resource('/bank', 'Ap\BankController');
    Route::get('/bank/update_status/{bank}', 'Ap\BankController@update_status');

    Route::resource('/bank_account', 'Ap\BankAccountController');
    Route::delete('/bank_account/delete/{bank}/{bank_account}', 'Ap\BankAccountController@destroy');
    Route::get('/bank_account/update_status/{bank}/{bank_account}', 'Ap\BankAccountController@update_status');

    Route::resource('/check', 'Ap\CheckController');
    Route::get('/check/get/{bank}/{bank_account}', 'Ap\CheckController@show');
    Route::get('/check/update_status/{check}/{bank}/{bank_account}', 'Ap\CheckController@update_status');
});