<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function isAdmin(){
        return $this->status == 1;
    }
    
    public function isClient(){
        
//        $l_clients=\App\assign::where('user_id',$this->id)->where('role_id',\App\role::client())->pluck("package_id")->get();
        $client=\App\assign::where('user_id',$this->id)->where('role_id',\App\role::client())->count();
        return $client > 0;
    
    }
}
