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
    return view('main');
});

Route::resource('product', ProductController::class);
Route::resource('company', CompanyController::class);
Route::resource('customer', CustomerController::class);
Route::resource('payment', PaymentController::class);
Route::post('/payment/{companyId}', 'PaymentController@setCompanyId');
