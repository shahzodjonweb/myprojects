<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    public function shippers(){
        return $this->hasMany(Shipper::class);
        }
}
