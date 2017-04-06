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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$role)
    {
        $this->user=$user;
//        $this->package=$package;
        $this->role=$role;
        
        
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        
        
        $this->cview = ($this->role == 'client') ? $this->forClient :$this->forCoach;
        
        
        return $this->view('emails.'.  $this->cview)
                ->from("demo@appsgenre.com", "COCpanel Admin")
                ->subject("A new response by your ".  $this->role)
                ->with('user',  $this->user);
//                ->with('package',  $this->package);
    }

}
