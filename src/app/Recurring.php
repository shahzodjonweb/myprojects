<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recurring extends Model
{
    public function driver(){
        return $this->belongsTo(Driver::class);
        }
}
