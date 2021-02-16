<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    public function user(){
        return $this->belongsTo(User::class);
        }
    public function driver(){
        return $this->belongsTo(Driver::class);
        }
        public function broker(){
            return $this->belongsTo(Broker::class);
            }
      
                public function pickup(){
                    $id=$this->id;
                    $shipper=Shipper::where("load_id",$id)->where("order",1)->get();
                    return $shipper[0];
                    }
                    public function delivery(){
                        $id=$this->id;
                        $order=Shipper::where("load_id",$id)->max('order');
                        $shipper=Shipper::where("load_id",$id)->where("order",$order)->get();
                        return $shipper[0];
                        }

                        public function shippers(){
                            return $this->hasMany(Shipper::class)->orderBy('order', 'asc');
                            }   

}
