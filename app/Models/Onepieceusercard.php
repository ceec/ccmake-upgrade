<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Onepieceusercard extends Model
{
    use HasFactory;

    // get all the user cards in the set
    public function usercards(): HasMany {
        return $this->hasMany(Onepieceusercard::class);
    }   

}
