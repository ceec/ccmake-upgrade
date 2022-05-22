<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Projectsteptag extends Model
{
    use HasFactory;

         /**
     * Get the category
     */
    public function tag()
    {
        return $this->belongsTo('App\Models\Tag');
    }   
}
