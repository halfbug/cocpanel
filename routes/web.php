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


Route::post('/documents/upload', 'DocumentController@docUploadPost');
Route::get('/documents/list/{module_id?}', 'DocumentController@listModuleDoc');
Route::delete('/documents/{doc_id?}', 'DocumentController@destroy');
