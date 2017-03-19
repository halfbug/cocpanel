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
}
