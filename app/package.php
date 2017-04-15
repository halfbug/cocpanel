<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class package extends Model {

    public $fillable = ['id', 'title', 'description', 'price', 'currency', 'paymnent_frequency', 'facebook_group', 'release_schedule'];
    protected $payment_frequencies = ['One Off', 'monthly', 'weekly', 'yearly'];
    protected $release_schedule = ['delivere immediately', 'rolling launch', 'one off launch', 'on completion of previous'];
    protected $appends = array('selected_modules','linked_clients');
//    protected $clients;

    public function getSelectedModulesAttribute() {
        return $this->modules()->get();
    }
    
    public function getLinkedClientsAttribute() {
        $l_clients=\App\assign::where('package_id',$this->package_id)->where('role_id',\App\role::client())->get();
        return $l_clients;
    }
    
    public function setSelectedModulesAttribute($value) {
        $this->modules()->detach();
        $this->modules()->attach($value);
    }

//    public $selected_modules;
    public function getPaymentsFrequencies() {
        return $this->payment_frequencies;
    }

    public function getReleaseSchedule() {
        return $this->release_schedule;
    }

    /**
     * The modules that belong to the package.
     */
    public function modules() {
        return $this->belongsToMany('App\module', 'package_module');
    }
    
   
    
    /**
     * Get the associated assignments
     *
     * @var array
     */
    public function coach(){
     
        return $this->hasMany('App\assignment');
    
    }
    
     public function getClients() {
        $clientsId = \App\assignment::where("package_id",  $this->id)->where("role_id",\App\role::client())->pluck("user_id");
        $clients=  \App\User::whereIn("id",$clientsId)->get();
        return $clients;
        
//        return "yes";
    }
    
    
     public function scopeOwner($query)
    {

          if(\Auth::user()->status == 2)
            return $query->join('assignments', 'packages.id', '=', 'assignments.package_id')->where('assignments.role_id', '=', \App\role::coache())->where('assignments.user_id',  \Auth::user()->id);
        else
            return $query;
        
    }
    
    
    /**
     * Get all of the clients that are assigned to this package.
     */
//    public function getClientsAttribute()
//    {
//        $clientRole= \App\role::where('name','client')->first();
//        $clients= \App\assign::where('role_id',$clientRole->id)->where('package_id',$this->id);
////        return $this->morphedByMany('App\assign', 'assginClients', $table = 'role_user_package', $foreignKey = 'package_id', $relatedKey = 'role_id');
//        return $clients;
//    }
//    
//    public function setClientsAttribute($values)
//    {
////        $clientRole= \App\role::where('name','client')->first();
////        $client = new App\assign
////        
////        return $clients;
//    }
    
    
    

}
