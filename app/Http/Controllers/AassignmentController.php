<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AassignmentController extends Controller {

    public function show(Request $request,$package_id, $module_id) {
        $role=$request->session()->get('role');
        
        if($role == 'client')
            $role_id= \App\role::client();
        else
            $role_id=\App\role::coache();
        
        $assignment = \App\assignment::where('role_id',$role_id )
                ->where("user_id", \Auth::user()->id)
                ->where("module_id", $module_id)
                ->where("package_id", $package_id)
                ->first();
        $module = \App\module::find($module_id);
        return view('module.preview')->with('module', $module)->with('assignment', $assignment);
//        return $package_id."/".$module_id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $package_id, $module_id) {
        $response = new \App\response();
        $response->content = $request->content;
        $response->save();

        $discussion = new \App\discussion();
        $discussion->user_id = $request->responseby;
        $discussion->question_id = $request->question_id;
        $discussion->assignment_id = $request->assignment_id;
        $discussion->response_id = $response->id;
        $discussion->save();

        return back()->with('package_id', $package_id)->with('module_id', $module_id);
    }

}
