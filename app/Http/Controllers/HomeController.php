<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
//        return "i m view";
        if(\Auth::user()->isClient()){
          
            return redirect('/clients/active_packages');
        }
        else{
//            return "inside";
            return view('home');
        }
            
    }
}
