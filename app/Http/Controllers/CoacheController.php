<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\User;
use App\Mail\NewCoachAdded;

class CoacheController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $collection = \App\assign::all();
        $users = \App\User::all();
        $coaches = \App\User::whereIn('status',[1,2])->orderBy('name','asc')->get(); 
//                $collection->where('role_id', \App\role::coache())->unique("user_id");
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
        session(['role' => 'coach']);
        
        if(\Auth::user()->isAdmin())
        $assignments = \App\assignment::where('role_id', \App\role::coache())->get();
        else
        $assignments = \App\assignment::where('role_id', \App\role::coache())->where("user_id", \Auth::user()->id)->get();    
            
        $collection = \App\assignment::all();
        $users = \App\User::all();

        return view('coache.activepack')->with('assignments', $assignments->unique("package_id"))
                        ->with('collection', $collection)->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
                    'status' => $data['status']
        ]);
    }

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    use RegistersUsers;

    public function store(Request $request) {
        try {
            $user =  \App\User::where('email',$request->email)->first();
            $error = 0;
//            var_dump($user);
//            var_dump($request->all());
            if (is_null($user)) {
                event(new Registered($user = $this->create($request->all())));
                \Mail::to($user->email)->send(new NewCoachAdded($user));
            } 
            elseif($user->first()->status != 0) {
                $user->status = 2;
                $user->save();
                \Mail::to($user->email)->send(new NewCoachAdded($user));
            }
            else{
                $user = "already exist";
                $error = 1;
            }
            


            return response()->json([$user,$error]);
        } catch (\Exception $e) {
            abort(500, 'OOps!!Some thing went wrong. Please try again.');
        }
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
