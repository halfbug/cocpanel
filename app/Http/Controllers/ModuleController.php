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
        $modules = Module::all();
        return view('module.index')->with('modules', $modules);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view ('module.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //
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
    public function edit(module $module) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, module $module) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(module $module) {
        //
    }

}
