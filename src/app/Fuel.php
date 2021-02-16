<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    public function driver(){
        return $this->belongsTo(Driver::class);
        }
}
