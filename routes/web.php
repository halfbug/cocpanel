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
    $module = App\Module::find($module_id);
    return response()->json($module);
});
Route::post('modules',function(Request $request){   
    $module = App\Module::create($request->all());
    return response()->json($module);
});
Route::put('modules/{module_id?}',function(Request $request,$module_id){
    $module = App\Module::find($module_id);
    $module->title = $request->title;
    $module->description = $request->description;
    $module->content = $request->content;
    $module->save();
    return response()->json($module);
});
Route::delete('modules/{module_id?}',function($module_id){
    $module = App\Module::destroy($module_id);
    return response()->json($module);
});
