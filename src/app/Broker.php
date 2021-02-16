<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Broker extends Model
{
    public function loads(){
        return $this->hasMany(Load::class)->orderBy('created_at', 'asc');
        }   
        public function user(){
            return $this->belongsTo(User::class);
            }
}
