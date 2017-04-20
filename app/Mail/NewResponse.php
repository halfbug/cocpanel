<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewResponse extends Mailable {

    use Queueable,
        SerializesModels;

    protected $forClient = "response_by_client";
    protected $forCoach = "response_by_coach";
    protected $user;
//    protected $package;
    protected $role;
    protected $cview;
    protected $module;  

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$role,$module)
    {
        $this->user=$user;
//        $this->package=$package;
        $this->role=$role;
        $this->module=$module;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        
        
        $this->cview = ($this->role == 'client') ? $this->forCoach :$this->forClient;
        
        
        return $this->view('emails.'.  $this->cview)
                ->from("demo@appsgenre.com", "Business BullsEye Admin")
                ->subject("Business BullsEye - New response by your ".  $this->role)
                ->with('user',  $this->user)
                ->with('moduleUrl',  url('assigned/'.session("assignment_id")))
                ->with('module',$this->module);
    }

}
