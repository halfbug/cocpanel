<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class assignment extends Model
{
     /**
     * Get the module .
     */
    public function module()
    {
        return $this->belongsTo('App\module');
    }
}
