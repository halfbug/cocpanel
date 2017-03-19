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

Route::get('modules/{module_id?}',function($module_id){
    $module = App\module::find($module_id);
    return response()->json($module);
});
Route::post('modules',function(Request $request){   
    $module = App\module::create($request->all());
    return response()->json($module);
});
Route::put('modules/{module_id?}',function(Request $request,$module_id){
    $module = App\module::find($module_id);
    $module->title = $request->title;
    $module->description = $request->description;
    $module->content = $request->content;
    $module->save();
    return response()->json($module);
});
Route::delete('modules/{module_id?}',function($module_id){
    $module = App\module::destroy($module_id);
    return response()->json($module);
});

Route::post('/documents/upload', 'DocumentController@docUploadPost');
Route::get('/documents/list/{module_id?}', 'DocumentController@listModuleDoc');
Route::delete('/documents/{doc_id?}', 'DocumentController@destroy');
