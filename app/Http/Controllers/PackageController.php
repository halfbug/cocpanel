<?php

namespace App\Http\Controllers;

use App\package;
use Illuminate\Http\Request;
use App\module;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $packages = package::owner()->get();
        $epackage= new package();
        $live_modules= module::where('is_live',true)->author()->get();        
        return view('package.index')->with('packages', $packages)->with('epackage',$epackage)
                ->with('live_modules' ,$live_modules);
                
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          $package = package::create($request->all());
          $package->modules()->attach($request->selected_modules);
          // auto set coache
          $assign = new \App\assign();
          $assign->coache(auth()->user()->id,$package->id);
          
        return response()->json($package);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function show($package_id)
    {
        $package = package::find($package_id);
//        $package->selected_modules ='["2","5"]';  //$package->modules()->get();
        return response()->json($package);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function edit($package_id)
    {
        $package = package::find($package_id);
        
//        return response()->json($package)->with('selected_modules',$package->modules()->get());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $package_id)
    {
        $package = package::find($package_id);
        $package->title = $request->title;
        $package->description = $request->description;
        $package->price = $request->price;
        $package->currency = $request->currency;
        $package->release_schedule = $request->release_schedule;
        $package->paymnent_frequency = $request->paymnent_frequency;
        $package->facebook_group = $request->facebook_group;
//        $package->selected_modulels = $request->selected_modules;
        $package->save();
        $package->setSelectedModulesAttribute($request->selected_modules);
        return response()->json($package);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\package  $package
     * @return \Illuminate\Http\Response
     */
    public function destroy(package $package)
    {
        //
    }
    
    
    public function showLinkedClients($package_id)
    {
        $package = package::find($package_id);
        return response()->json(['clients'=>$package->getClients(),'coach'=>$package->getCoach()]);
    }
}