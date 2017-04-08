<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model {

    public $fillable = [ 'role_id', 'user_id', 'package_id', 'module_id', 'status', 'coache_id'];
    protected $appends = array('client','coach');
//    protected $clients;

    public function getClientAttribute() {
        return $this->user();
    }
    
    public function getCoachAttribute() {
        return ($this->coache_id)?\App\User::where('id',  $this->coach_id):\App\User::where('id',  $this->user_id);
    }
    

    /**
     * status filed can hold
     * 1 for active module
     * 2 for in progress module
     * 3 for in pending module
     * 4 for completion of module
     *  */
    protected $moduleStatus = [
        1 => 'Completed',
        2 => 'Pending',
        3 => 'Active'
    ];

    public function getStatus() {
        return $this->moduleStatus[$this->status];
    }

    public function saveClient($auser_id, $apackage_id) {

        $role_id = \App\role::client();

        $pack = $this->getPackage($apackage_id);
        $module = $pack->selected_modules->first();

        self::create(['role_id' => $role_id,
            'user_id' => $auser_id,
            'package_id' => $apackage_id,
            'module_id' => $module->id,
            'status' => 3, 
            'coache_id' => $this->coach
            ]);


        return $this;
    }

    /**
     * Get the module .
     */
    public function module() {
        return $this->belongsTo('App\module');
    }

    /**
     * Get the associated discussions
     *
     * @var array
     */
    public function discussions() {

        return $this->hasMany('App\discussion');
    }

    /**
     * Get the package .
     */
    public function package() {
        return $this->belongsTo('App\package');
    }

    /**
     * Get the package .
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

}
