<?php

use Illuminate\Support\Facades\Auth;
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

//Auth Routes
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//All Invoices Routes
Route::resource('invoices', 'InvoicesController');
Route::resource('InvoiceAttachments', 'InvoicesAttachmentsController');
Route::resource('Invoices_Archive', 'InvoicesArchiveController');
Route::get("section/{id}" , 'InvoicesController@get_products');
Route::get("InvoicesDetails/{id}" , 'InvoicesDetailsController@show')->name('InvoicesDetails');
Route::get("View_file/{invoice_number}/{file_name}" , 'InvoicesDetailsController@view_file');
Route::get("Download_file/{invoice_number}/{file_name}" , 'InvoicesDetailsController@download_file');
Route::get("edit_invoice/{id}" , 'InvoicesController@edit');
Route::get('status_show/{id}', 'InvoicesController@show')->name('status_show');
Route::get('Paid_Invoices' , 'InvoicesController@paid_invoices');
Route::get('Unpaid_Invoices' , 'InvoicesController@unpaid_invoices');
Route::get('Partial_Invoices' , 'InvoicesController@partial_invoices');
Route::get('Print_Invoice/{id}' , 'InvoicesController@print_invoice');
Route::get('Export_Invoices/{page_id}', 'InvoicesController@export');
Route::get('Invoices_Reports' , 'InvoicesReportsController@index');
Route::get('Customers_Reports' , 'CustomersReportsController@index');
Route::get('MarkAsRead_All','InvoicesController@MarkAsRead_All')->name('MarkAsRead_All');
Route::get('MarkAsRead','InvoicesController@MarkAsRead')->name('MarkAsRead');
Route::get('All_Notifications' , 'InvoicesController@View_All_Notification')->name('All_Notifications');
Route::post('Search_Invoices' , 'InvoicesReportsController@search_invoices');
Route::post('Search_Customers' , 'CustomersReportsController@search_customers');
Route::post('Delete_file', 'InvoicesDetailsController@destroy')->name('Delete_file');
Route::post('status_update/{id}', 'InvoicesController@status_update')->name('status_update');

//All Sections Routes
Route::resource('sections', 'SectionsController');

//All Products Routes
Route::resource('products', 'ProductsController');

//Users && Roles Routes
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::get('profile' , 'UserController@profile')->name('profile');
});

//Admin Routes
Route::get('/{page}', 'AdminController@index');
