<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class module extends Model
{
     public $fillable = ['title','description','content'];
     
     /**
     * Get the associated documents
     *
     * @var array
     */
    public function documents(){
     
        return $this->hasMany('App\document');
    
    }
    
    /**
     * Get the associated questions
     *
     * @var array
     */
    public function questions(){
     
        return $this->hasMany('App\question');
    
    }
    
    /**
     * The packages that belong to the module.
     */
    public function packages()
    {
        return $this->belongsToMany('App\package', 'package_module');
    }
}
