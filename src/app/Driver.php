<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject; 
use Illuminate\Foundation\Auth\User as Authenticatable;
class Driver extends Authenticatable implements JWTSubject
{
   
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }    

    public function user(){
        return $this->belongsTo(User::class);
        }
        public function loads(){
            return $this->hasMany(Load::class);
            }
            public function currentload(){
                $id=$this->id;
                $load=Load::where('user_id',Auth::user()->main)->where("driver_id",$id)->whereIn("status",["active","inactive"])->orderBy('created_at', 'DESC')->first();
                return $load;
                }

                public function recurrings(){
                    return $this->hasMany(Recurring::class);
                    }

                    public function deductions(){
                        return $this->hasMany(Deduction::class);
                        }

                        public function fuels(){
                            return $this->hasMany(Fuel::class);
                            }

                            // <<<   لا إله إلا الله محمد رسول الل  - lā ʾilāha ʾillā llāhu muḥammadun rasūlu llāhi  >>>>

                            public function getWeeklyRevenueCompany($p_id,$for){

                                if($p_id==1){
                                    $admin=Admin::where('user_id',Auth::user()->main)->get();
                                    $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
                                    if(($dayOfTheWeek-$admin[0]->weekindex)>0){
                                      $weekly=$dayOfTheWeek-$admin[0]->weekindex;
                                    }else{
                                      $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
                                    }
                                    $date = \Carbon\Carbon::today() ->subDays($weekly-1);
                                    
                                    $loads = Load::where('user_id',Auth::user()->main)->where('driver_id',$this->id)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
                                    $fuels = Fuel::where('driver_id',$this->id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                                    $recurrings = Recurring::where('driver_id',$this->id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                                    $deductions = Deduction::where('driver_id',$this->id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                                     $admin=$admin[0];
                                    //will return revenue inshallah
                                    if($for=='company'){
                                    return (($loads->sum('price')-($loads->sum('milage')+$loads->sum('deadhead')-$loads->sum('deadhead_d'))*$admin->permile) - $recurrings->sum('price')+($deductions->sum('price'))-$fuels->sum('price'));
                                    }
                                    if($for=='owner'){
                                        return ($loads->sum('price')*$admin->dispatch_fee/100-$recurrings->sum('price')+($deductions->sum('price')+$admin->insurance+$admin->eld+$admin->ifta));
                                    }
                                    if($for=='lease'){
                                        return ($loads->sum('price')*$admin->dispatch_fee/100-$recurrings->sum('price')+($deductions->sum('price')+$admin->insurance+$admin->eld+$admin->ifta+$admin->lease));
                                    }

                                }else{
                                    $main=Admin::where('user_id',Auth::user()->main)->get();
                                     $dayOfTheWeek = \Carbon\Carbon::now()->dayOfWeek;
                                     if(($dayOfTheWeek-$main[0]->weekindex)>0){
                                       $weekly=$dayOfTheWeek-$main[0]->weekindex;
                                     }else{
                                       $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
                                     }
                                 
                                     $date = \Carbon\Carbon::today() ->subDays(7*($p_id-1)+$weekly-1);
                                    
                                     $admin=Cache::where('started_at',$date)->get();
                                     $loads = Load::where('user_id',Auth::user()->main)->where('driver_id',$this->id)->where('ended_at','>=',$admin[0]->started_at)->where('ended_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                                    $fuels = Fuel::where('driver_id',$this->id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                                    $recurrings = Recurring::where('driver_id',$this->id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                                    $deductions = Deduction::where('driver_id',$this->id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                                    $admin=$main[0];


                                    if($for=='company'){
                                        return (($loads->sum('price')-($loads->sum('milage')+$loads->sum('deadhead')-$loads->sum('deadhead_d'))*$admin->permile) - $recurrings->sum('price')+($deductions->sum('price'))-$fuels->sum('price'));
                                        }
                                        if($for=='owner'){
                                            return ($loads->sum('price')*$admin->dispatch_fee/100-$recurrings->sum('price')+($deductions->sum('price')+$admin->insurance+$admin->eld+$admin->ifta));
                                        }
                                        if($for=='lease'){
                                            return ($loads->sum('price')*$admin->dispatch_fee/100-$recurrings->sum('price')+($deductions->sum('price')+$admin->insurance+$admin->eld+$admin->ifta+$admin->lease));
                                        }
                                }
 
  
                            }

                            public function getWeeklyRevenueDriver($p_id,$for){

                                if($p_id==1){
                                    $admin=Admin::where('user_id',Auth::user()->main)->get();
                                    $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
                                    if(($dayOfTheWeek-$admin[0]->weekindex)>0){
                                      $weekly=$dayOfTheWeek-$admin[0]->weekindex;
                                    }else{
                                      $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
                                    }
                                    $date = \Carbon\Carbon::today() ->subDays($weekly-1);
                                    
                                    $loads = Load::where('user_id',Auth::user()->main)->where('driver_id',$this->id)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
                                    $fuels = Fuel::where('driver_id',$this->id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                                    $recurrings = Recurring::where('driver_id',$this->id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                                    $deductions = Deduction::where('driver_id',$this->id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                                     $admin=$admin[0];
                                    //will return revenue inshallah
                                    if($for=='company'){
                                    return ($loads->sum('milage')+$loads->sum('deadhead')-$loads->sum('deadhead_d'))*$admin->permile+$recurrings->sum('price')-($deductions->sum('price'));
                                    }
                                    if($for=='owner'){
                                        return ($loads->sum('price')*(100-$admin->dispatch_fee)/100+$recurrings->sum('price')-($deductions->sum('price')+$admin->insurance+$fuels->sum('price')+$admin->eld+$admin->ifta));
                                    }
                                    if($for=='lease'){
                                        return ($loads->sum('price')*(100-$admin->dispatch_fee)/100+$recurrings->sum('price')-($deductions->sum('price')+$admin->insurance+$fuels->sum('price')+$admin->eld+$admin->ifta+$admin->lease));
                                    }

                                }else{
                                    $main=Admin::where('user_id',Auth::user()->main)->get();
                                     $dayOfTheWeek = \Carbon\Carbon::now()->dayOfWeek;
                                     if(($dayOfTheWeek-$main[0]->weekindex)>0){
                                       $weekly=$dayOfTheWeek-$main[0]->weekindex;
                                     }else{
                                       $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
                                     }
                                 
                                     $date = \Carbon\Carbon::today() ->subDays(7*($p_id-1)+$weekly-1);
                                    
                                     $admin=Cache::where('started_at',$date)->get();
                                     $loads = Load::where('user_id',Auth::user()->main)->where('driver_id',$this->id)->where('ended_at','>=',$admin[0]->started_at)->where('ended_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                                    $fuels = Fuel::where('driver_id',$this->id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                                    $recurrings = Recurring::where('driver_id',$this->id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                                    $deductions = Deduction::where('driver_id',$this->id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                                    $admin=$main[0];


                                    if($for=='company'){
                                        return ($loads->sum('milage')+$loads->sum('deadhead')-$loads->sum('deadhead_d'))*$admin->permile+$recurrings->sum('price')-($deductions->sum('price'));
                                        }
                                        if($for=='owner'){
                                            return ($loads->sum('price')*(100-$admin->dispatch_fee)/100+$recurrings->sum('price')-($deductions->sum('price')+$admin->insurance+$fuels->sum('price')+$admin->eld+$admin->ifta));
                                        }
                                        if($for=='lease'){
                                            return ($loads->sum('price')*(100-$admin->dispatch_fee)/100+$recurrings->sum('price')-($deductions->sum('price')+$admin->insurance+$fuels->sum('price')+$admin->eld+$admin->ifta+$admin->lease));
                                        }
                                }
 
  
                            }

                           
          
}
