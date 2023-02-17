<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pairing;


class Volume extends Model
{
    use HasFactory;

    public function pairing()
    {
        return $this->belongsTo('App\Models\Pairing');
    }     
}
