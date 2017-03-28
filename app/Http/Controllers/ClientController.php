<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller {

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
        
       
        
         return view('client.index')->with('collection', $collection)
                ->with('users',$users)->with("coaches",$coaches);
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
        $pack_id = $request->package_id;
        $request->password=bcrypt($request->password);
        $user = \App\User::create([
            'name'=>$request->name, 
            'email' => $request->email, 
            'password' => bcrypt($request->password),
          
        ]);
        $clientRole = \App\role::client();
        $client = new \App\assign();
        $client->role_id = $clientRole;
        $client->user_id = $user->id;
        $client->package_id = $request->package_id;
        $client->save();
        return response()->json($client);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeExisting(Request $request) {
        $pack_id = $request->package_id;
        $emails = $request->emails;
        $emails = preg_replace('/\s+/', '', $emails);
        $users = \App\User::whereIn('email', explode(",", $emails))->get();
        
        $clients = [];
        foreach ($users as $user) {

            $assign = new \App\assign();
            $assign->client($user->id, $request->package_id);
            
            $clients[]=$user->email;
        }
        return response()->json(implode(", ", $clients));
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
