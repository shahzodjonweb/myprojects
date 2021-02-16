<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipper extends Model
{
    public function location(){
        return $this->belongsTo(Location::class);
        }
        // public function load(){
        //     return $this->belongsTo(Load::class);
        //     }
        public function localDate(){
            $id=$this->id;
            $time=str_replace(' ', 'T', $this->time);
            return $time;
            }
            public function getLocationFormat(){
                $id=$this->location_id;
                $location=Location::find($id);
                $locationstring=$location->zipcode.'|'.$location->county.', '.$location->city.' '.$location->state;
                return $locationstring;
            }
            public function getLocationFormat2(){
                $id=$this->location_id;
                $location=Location::find($id);
                $locationstring=$location->city.' '.$location->state;
                return $locationstring;
            }
}
