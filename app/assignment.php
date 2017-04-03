<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
     public $fillable = ['role_id','user_id','package_id','module_id','status'];
    
    /**
     * Get the module .
     */
    public function module()
    {
        return $this->belongsTo('App\module');
    }
    
    /**
     * Get the associated discussions
     *
     * @var array
     */
    public function discussions(){
     
        return $this->hasMany('App\discussion');
    
    }
    
    /**
     * Get the package .
     */
    public function package()
    {
        return $this->belongsTo('App\package');
    }
}
