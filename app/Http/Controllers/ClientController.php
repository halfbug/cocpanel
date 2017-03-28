<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use App\User;

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
                        ->with('users', $users)->with("coaches", $coaches);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function create() {
//        //
//    }

/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    use RegistersUsers;

    public function store(Request $request) {
        $pack_id = $request->package_id;
        $request->password = bcrypt($request->password);
//        $user = \App\User::create([
//            'name'=>$request->name, 
//            'email' => $request->email, 
//            'password' => bcrypt($request->password),
//          
//        ]);
        event(new Registered($user = $this->create($request->all())));

//        $clientRole = \App\role::client();
        $assign = new \App\assign();
        $client = $assign->client($user->id, $request->package_id);
//        $client->role_id = $clientRole;
//        $client->user_id = $user->id;
//        $client->package_id = $request->package_id;
//        $client->save();
        $package_clients = \App\package::find($request->package_id)->linked_clients;

        return response()->json([
                    'client' => $client,
                    'totalclients' => $package_clients->count()
        ]);
    }

    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
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

            $clients[] = $user->email;
        }
        
        $package_clients = \App\package::find($request->package_id)->linked_clients;
        return response()->json([
        'clients' => implode(", ", $clients),
        'totalclients' => $package_clients->count()
        ]);
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
