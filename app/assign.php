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

        $role_id = \App\role::client();
       
        $pack= $this->getPackage($apackage_id);
        foreach($pack->selected_modules as $module)
        {
            \App\assignment::create(['role_id' => $role_id, 'user_id' => $auser_id, 'package_id' =>$apackage_id, 'module_id'=> $module->id]);
        }

        return $this;
    }
    
    public function getPackage($package_id){
        return \App\package::where('id',$package_id)->first();
    }

    public function coache($auser_id, $apackage_id) {

        $this->role_id = \App\role::coache();
        $this->user_id = $auser_id;
        $this->package_id = $apackage_id;
        $this->module_id = $this->getPackage($apackage_id)->selected_modules->first()->id;
            
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
