<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Volume;

class Group extends Model
{
    use HasFactory;

    public function volumes() {
        return $this->hasMany('App\Models\Volume');
    }

}
