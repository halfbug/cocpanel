<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\NewResponse;

class AassignmentController extends Controller {

    public function show(Request $request, $assignment_id) {
        $role = $request->session()->get('role');
        $assignment = \App\assignment::find($assignment_id);
                
        
        if ($role == 'client') {
//            $role_id = \App\role::client();
            $client_id = \Auth::user()->id;

            $coach_id = \App\assignment::find($assignment->coache_id)->user_id;
            
        } else {
//            $role_id = \App\role::coache();
            $client_id=$assignment->user_id;
            $coach_id = \Auth::user()->id;
            
        }

        session(['client' => \App\User::find($client_id)]);
        session(['coach' => \App\User::find($coach_id)]);

        
        
        $module = \App\module::find($assignment->module_id);
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

        $assignment = $discussion->assignment()->first();
        // email to client on coach response
        $user = $discussion->user()->first();

        if(\Auth::user()->isCoach() || \Auth::user()->isAdmin())
            \Mail::to($assignment->user->email)->send(new NewResponse($user, 'coach'));
        else
            \Mail::to($assignment->coach->email)->send(new NewResponse($user, 'client'));
        // email to coach on client response


        return back()->with('package_id', $package_id)->with('module_id', $module_id);
    }
    
    
    public function updateStatus(Request $request) {
        echo $request->assignment_id;
        if($request->assignment_id == 0)
        {
            $assign =\App\assignment::create([
                'role_id'=>\App\role::client(),
                'user_id'=>$request->user_id,
                'package_id'=>$request->package_id,
                'module_id'=>$request->module_id,
                'status'=>$request->status
                ]);
        }
        else{
            $assign=\App\assignment::find($request->assignment_id);
            $assign->status = $request->status;
            $assign->save();
        }
        
        return back();
    }

}
