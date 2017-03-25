<?php

namespace App\Http\Controllers;

use App\module;
use Illuminate\Http\Request;

class ModuleController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $modules = module::all()->where('is_live',false);
        $live_modules = module::all()->where('is_live',true);
        return view('module.index')->with('modules', $modules)
                ->with('live_modules',$live_modules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('module.create');
    }
    /**
     * Available modules.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return json
     */
    public function getLive() {
        $module = module::all()->where('is_live',true);
        return response()->json($module);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $module = module::create($request->all());
        return response()->json($module);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(module $module) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit($module_id) {
        $module = module::find($module_id);
        return response()->json($module);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $module_id) {
        $module = module::find($module_id);
        $module->title = $request->title;
        $module->description = $request->description;
        $module->content = $request->content;
        $module->save();
        return response()->json($module);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy($module_id) {
        $module = module::destroy($module_id);
        return response()->json($module);
    }
    
    
     /**
     * update to live module.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function makeLive($module_id) {
        $module = module::find($module_id);
        $module->is_live = true;
        $module->save();
        return response()->json($module);
    }

}
