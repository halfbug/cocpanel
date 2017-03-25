<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class package extends Model {

    public $fillable = ['id', 'title', 'description', 'price', 'currency', 'paymnent_frequency', 'facebook_group', 'release_schedule'];
    protected $payment_frequencies = ['One Off', 'monthly', 'weekly', 'yearly'];
    protected $release_schedule = ['delivere immediately', 'rolling launch', 'one off launch', 'on completion of previous'];
    protected $appends = array('selected_modules');

    public function getSelectedModulesAttribute() {
        return $this->modules()->get();
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

}
