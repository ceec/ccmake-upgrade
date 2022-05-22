<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectstep extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projectsteps';    

    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }

        public function tags()
    {
        return $this->hasMany('App\Models\Projectsteptag');
    }   

    public function tools() {
    	return $this->hasMany('App\Models\Projectsteptool');
    } 


    public function movie() {
        return $this->belongsTo('App\Models\Movie');
    }

}
