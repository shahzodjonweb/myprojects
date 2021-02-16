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
    return view('welcome');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*  <=================   Routes for LoadController =====================>  */
Route::post('load/searchload/{type}', 'LoadController@searchload')->middleware('auth');
Route::post('load/getLocation', 'LoadController@getLocation')->middleware('auth');
Route::get('load/createPDF', 'LoadController@createPDF')->middleware('auth');
Route::post('load/deleteLoad', 'LoadController@deleteLoad')->middleware('auth');
Route::get('load/create2', 'LoadController@create2')->middleware('auth');
Route::post('load/changestatus', 'LoadController@changestatus')->middleware('auth');
Route::get('load/activeloads', 'LoadController@liveboard')->middleware('auth');
Route::resource('load', 'LoadController')->middleware('auth');

/*  <=================   Routes for DriverController =====================>  */
Route::post('driver/changestatus', 'DriverController@changestatus')->middleware('auth');
Route::post('driver/deleteDriver', 'DriverController@deleteDriver')->middleware('auth');
Route::get('driver/driverloads', 'DriverController@driverloads')->middleware('auth');
Route::post('driver/changecomment', 'DriverController@changecomment')->middleware('auth');
Route::get('driver/activedrivers', 'DriverController@liveboard')->middleware('auth');
Route::resource('driver', 'DriverController')->middleware('auth');

/*  <=================   Routes for DriverReportController =====================>  */
Route::post('report/sortByDateDrivers/{id}', 'DriverReportController@sortByDateDrivers')->middleware('auth');
Route::post('report/sortByDate', 'DriverReportController@sortByDate')->middleware('auth');
Route::get('report/showcompany1', 'DriverReportController@showcompany1')->middleware('auth');
Route::post('report/showcompany2', 'DriverReportController@showcompany2')->middleware('auth');
Route::post('report/showselection/{id}', 'DriverReportController@showselection')->middleware('auth');
Route::post('report/addfuel', 'DriverReportController@addfuel')->middleware('auth');
Route::post('report/addrecurring', 'DriverReportController@addrecurring')->middleware('auth');
Route::post('report/adddeduction', 'DriverReportController@adddeduction')->middleware('auth');
// Route::get('driver/driverloads', 'DriverReportController@driverloads')->middleware('auth');
// Route::post('driver/changecomment', 'DriverReportController@changecomment')->middleware('auth');
// Route::get('driver/activedrivers', 'DriverReportController@liveboard')->middleware('auth');
Route::resource('report', 'DriverReportController')->middleware('auth');

/*  <=================   Routes for BrokerController =====================>  */
Route::post('broker/addBroker', 'BrokerController@addBroker')->middleware('auth');
Route::resource('broker', 'BrokerController')->middleware('auth');

/*  <=================   Routes for AdminController =====================>  */
Route::post('admin/register_user', 'AdminController@register_user');
Route::get('admin/payment', 'AdminController@payment')->middleware('auth');
Route::resource('admin', 'AdminController')->middleware('auth');
