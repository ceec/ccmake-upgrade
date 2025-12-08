<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onepiececharacter extends Model {
    use HasFactory;

    // Return the set number for images, no dash
    public function imageNumber() {

        return str_replace('-','',$this->shortname);
    }
}
