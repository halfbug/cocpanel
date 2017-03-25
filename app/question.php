<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    public $fillable = ['sno','content','module_id'];
     
      /**
     * Get the module that owns the documents.
     */
    public function module()
    {
        return $this->belongsTo('App\module');
    }
}
