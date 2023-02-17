<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

     /**
     * Get the steps for the project.
     */
    public function steps()
    {
        return $this->hasMany('App\Models\Projectstep');
    }    

      /**
     * Get the category
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }  
    
     /**
     * Get the most recent step
     */
    public function recentStep()
    {
        return $this->hasMany('App\Models\Projectstep')->latest()->take(1);
    }    
}
