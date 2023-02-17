<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    public function author() {
        return $this->belongsTo('App\Models\Author');
    }

    public function type() {
        return $this->belongsTo('App\Models\Type');
    }

    public function publisher() {
        return $this->belongsTo('App\Models\Publisher');
    }

    public function group() {
        return $this->belongsTo('App\Models\Group');
    }
}
