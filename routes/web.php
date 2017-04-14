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

use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/modules', 'ModuleController@index');

//Route::get('/modules/add', 'ModuleController@create');

Route::get('modules/{module_id?}','ModuleController@edit');
Route::post('modules','ModuleController@store');
Route::put('modules/{module_id?}','ModuleController@update');
Route::delete('modules/{module_id?}','ModuleController@destroy');
Route::put('modules/make_live/{module_id?}','ModuleController@makeLive');
Route::get('modules/live','ModuleController@getLive');
Route::get('modules/preview/{module_id?}','ModuleController@show');
Route::post('modules/make_copy/{module_id}','ModuleController@makeCopy');


Route::post('/documents/upload', 'DocumentController@docUploadPost');
Route::get('/documents/list/{module_id?}', 'DocumentController@listModuleDoc');
Route::delete('/documents/{doc_id?}', 'DocumentController@destroy');


Route::group(['prefix' => 'questions'], function () {
    Route::get('list/{module_id?}', 'QuestionController@grid');
    Route::post('/','QuestionController@store');
    Route::put('{question_id}','QuestionController@update');
    Route::get('{question_id}','QuestionController@show');
    Route::delete('{question_id}','QuestionController@destroy');
    
});

Route::group(['prefix' => 'packages'], function () {
    Route::get('/', 'PackageController@index');
    Route::post('/','PackageController@store');
    Route::put('{package_id}','PackageController@update');
    Route::get('{package_id}','PackageController@show');
    Route::delete('{package_id}','PackageController@destroy');
    Route::get('/linked_clients/{package_id}','PackageController@showLinkedClients');
});

Route::group(['prefix' => 'clients'], function () {
    Route::get('/active_packages','ClientController@activePackages');
    Route::get('/', 'ClientController@index');
    Route::post('/','ClientController@store');
    Route::post('/addExisting','ClientController@storeExisting');
    Route::put('{package_id}','ClientController@update');
//    Route::get('{package_id}','ClientController@show');
    Route::delete('{client_id}','ClientController@destroy');
    
    
});

Route::group(['prefix' => 'coaches'], function () {
    Route::get('/', 'CoacheController@index');
    Route::post('/','CoacheController@store');
    Route::get('/active_packages','CoacheController@activePackages');
});

Route::group(['prefix' => 'assigned'], function () {
    Route::get('/{assigned_id}', 'AassignmentController@show');
    Route::post('/{package_id}/{module_id}', 'AassignmentController@store');
     Route::post('/update_status', 'AassignmentController@updateStatus');
    
});
