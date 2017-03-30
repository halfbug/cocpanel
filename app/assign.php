<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assign extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'assignments';

    public function client($auser_id, $apackage_id) {

        $this->role_id = \App\role::client();
        $this->user_id = $auser_id;
        $this->package_id = $apackage_id;
        $this->save();

        return $this;
    }

    public function coache($auser_id, $apackage_id) {

        $this->role_id = \App\role::coache();
        $this->user_id = $auser_id;
        $this->package_id = $apackage_id;
        $this->save();

        return $this;
    }

    public function getName($users) {
        $user = $users->where("id", $this->user_id)->first();
        return $user->name;
        
//        return "yes";
    }
    
     public function getClients($users,$collection) {
        $pack = $collection->where("user_id",  $this->user_id)->unique("package_id")->pluck("package_id");
        $clientsId = $collection->whereIn("package_id",$pack)->where("role_id",\App\role::client())->unique("user_id")->pluck("user_id");
        $clients=$users->whereIn("id",$clientsId);
        return $clients;
        
//        return "yes";
    }
    
    public function getPackages($users,$collection) {
        $pack = $collection->where("user_id",  $this->user_id)->unique("package_id")->pluck("package_id");
        $pacakages= \App\package::whereIn("id",$pack)->get();
        return $pacakages;
        
//        return "yes";
    }

}
