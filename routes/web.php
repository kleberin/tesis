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
Route::get('/home/live', 'HomeController@getLiveData')->name('home-live');

Route::get('/upload-work-order', 'HomeController@upload')->name('upload-wo');
Route::get('/update-work-order', 'HomeController@update')->name('update-wo');

Route::post('/upload-receiver', 'HomeController@uploadCsv')->name('upload.csv');
Route::post('/update-receiver', 'HomeController@updateCsv')->name('update.csv');
Route::post('/exec-sps', 'HomeController@executeSps')->name('execute.sps');

Route::get('/tracking/live', 'TrackingController@getLiveData')->name('tracking.live');
Route::get('/tracking/{userId}/history', 'TrackingController@getTrackingData')->name('tracking.data');

Route::get('/technician/{id}', 'TechnicianController@index')->name('technician.index');

Route::get('/work-order/live', 'WorkOrderController@getLiveData')->name('workOrder.live');
Route::get('/work-order/created', 'WorkOrderController@getCreatedData')->name('workOrder.created');
Route::get('/work-order/asigd', 'WorkOrderController@getAsigdData')->name('workOrder.asigd');

Route::get('/dealer/list', 'DealerController@list')->name('dealer.list');