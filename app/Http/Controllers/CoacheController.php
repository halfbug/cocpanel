<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoacheController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $collection = \App\assign::all();
        $users = \App\User::all();
        $coaches = $collection->where('role_id', \App\role::coache())->unique("user_id");
//        return $coaches;



        return view('coache.index')->with('collection', $collection)
                        ->with('users', $users)->with("coaches", $coaches);
    }

    /**
     * Display a listing of the active packages.
     *
     * @return \Illuminate\Http\Response
     */
    public function activePackages(Request $request) {
        session(['role' => 'coache']);
        $assignments = \App\assignment::where('role_id', \App\role::coache())->where("user_id", \Auth::user()->id)->get();
        $collection = \App\assignment::all();
        $users = \App\User::all();

        return view('coache.activepack')->with('assignments', $assignments->unique("package_id"))
                ->with('collection',$collection)->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
