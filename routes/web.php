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
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('invoices', 'InvoicesController');
Route::resource('InvoiceAttachments', 'InvoicesAttachmentsController');
Route::get("/section/{id}" , 'InvoicesController@get_products');
Route::get("/InvoicesDetails/{id}" , 'InvoicesDetailsController@show');
Route::get("/View_file/{invoice_number}/{file_name}" , 'InvoicesDetailsController@view_file');
Route::get("/Download_file/{invoice_number}/{file_name}" , 'InvoicesDetailsController@download_file');
Route::post('Delete_file', 'InvoicesDetailsController@destroy')->name('Delete_file');
Route::get("/edit_invoice/{id}" , 'InvoicesController@edit');
Route::get('/status_show/{id}', 'InvoicesController@show')->name('status_show');
Route::post('/status_update/{id}', 'InvoicesController@status_update')->name('status_update');
Route::get('Paid_Invoices' , 'InvoicesController@paid_invoices');
Route::get('Unpaid_Invoices' , 'InvoicesController@unpaid_invoices');
Route::get('Partial_Invoices' , 'InvoicesController@partial_invoices');
Route::resource('Invoices_Archive', 'InvoicesArchiveController');

Route::resource('sections', 'SectionsController');

Route::resource('products', 'ProductsController');

Route::get('/{page}', 'AdminController@index');
