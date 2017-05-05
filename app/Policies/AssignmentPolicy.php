<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\assignment;

class AssignmentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    
    public function sendcoachAlert(User $user , assignment $assignment)
    {
       if($assignment->package()->first()->status == 0)
            $clientReply=true;
        else
            $clientReply=false;
//        var_dump; 
       if(\Auth::user()->isCoach() || \Auth::user()->isAdmin())
           if($clientReply && ($assignment->coach->id == \Auth::user()->id)) 
               return true;
    }
    
    public function sendclientAlert(User $user , assignment $assignment)
    {
       if((\Auth::user()->id == $assignment->user->id ) )
           return true;
    }
}
