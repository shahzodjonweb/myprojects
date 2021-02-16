<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Load;
use App\Driver;
use App\User;
use App\Truck;
use App\Fuel;
use App\Recurring;
use App\Deduction;
use App\Admin;
use App\Cache;
use Carbon\Carbon;
use Auth;
class DriverReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $drivers=Driver::where('user_id',Auth::user()->main)->where('user_id',Auth::user()->main)->orderBy('created_at', 'desc')->get();
        return view('driverreport.index')->with("drivers",$drivers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $this->checker();
      $caches_n=count(Cache::where('user_id',Auth::user()->main)->get());
      // <<  ٱلْحَمْدُ لِلَّٰهِ Alhamdulillah‎ >>
  $admin=Admin::where('user_id',Auth::user()->main)->get();
  $driver=Driver::find($id);
  $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
  if(($dayOfTheWeek-$admin[0]->weekindex)>0){
    $weekly=$dayOfTheWeek-$admin[0]->weekindex;
  }else{
    $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
  }
  $date = \Carbon\Carbon::today() ->subDays($weekly-1);
        $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      return view('driverreport.reports')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',1);
    }

    public function showselection(Request $request,$id)
    {
      $caches_n=count(Cache::where('user_id',Auth::user()->main)->get());
      $this->checker();
      if($request['selection']==1){
      // <<  ٱلْحَمْدُ لِلَّٰهِ Alhamdulillah‎ >>
  $admin=Admin::where('user_id',Auth::user()->main)->get();
  $driver=Driver::find($id);
  $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
  if(($dayOfTheWeek-$admin[0]->weekindex)>0){
    $weekly=$dayOfTheWeek-$admin[0]->weekindex;
  }else{
    $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
  }
  $date = \Carbon\Carbon::today() ->subDays($weekly-1);
        $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      return view('driverreport.reports')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',$request['selection']);
      }else{
      
        
       $main=Admin::where('user_id',Auth::user()->main)->get();
        $driver=Driver::find($id);
        $dayOfTheWeek = \Carbon\Carbon::now()->dayOfWeek;
        if(($dayOfTheWeek-$main[0]->weekindex)>0){
          $weekly=$dayOfTheWeek-$main[0]->weekindex;
        }else{
          $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
        }

        $date = \Carbon\Carbon::today() ->subDays(7*($request['selection']-1)+$weekly-1);
       dd($date);
        $admin=Cache::where('user_id',Auth::user()->main)->where('started_at',$date)->get();

        
       
        $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('ended_at','>=',$admin[0]->started_at)->where('ended_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
      $fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
      $recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
      $deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
      return view('driverreport.reports')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',$request['selection']);
      }
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addfuel(Request $request)
    {
      // dd($request);
        $id=$request['driverId'];
        $fuel=new Fuel();
        $fuel->date=$request['date'];
        $fuel->state=$request['state'];
        $fuel->price=$request['price'];
        $fuel->driver_id=$id;
        $fuel->save();

        
        $driver=Driver::find($id);
        $date = \Carbon\Carbon::today()->subDays(7);

        $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      return back()->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load);
    }
    public function addrecurring(Request $request)
    {
        $id=$request['driverId'];
        $recurring=new Recurring();
        $recurring->name=$request['name'];
        $recurring->price=$request['price'];
        $recurring->driver_id=$id;
        $recurring->save();
        $driver=Driver::find($id);
        $date = \Carbon\Carbon::today()->subDays(7);

        $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      return back()->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load);
    }
    public function adddeduction(Request $request)
    {
        $id=$request['driverId'];
        $deduction=new Deduction();
        $deduction->name=$request['name'];
        $deduction->price=$request['price'];
        $deduction->driver_id=$id;
        $deduction->save();

        
        $driver=Driver::find($id);
        $date = \Carbon\Carbon::today()->subDays(7);

        $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      return back()->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load);
    }


    public function checker(){
  //     $main=Admin::where('user_id',Auth::user()->main)->get();
  //     $date1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', '2021-01-23 11:53:20');
  //     $dayOfTheWeek = $date1->dayOfWeek;
  //     if(($dayOfTheWeek-$main[0]->weekindex)>0){
  //       $weekly=$dayOfTheWeek-$main[0]->weekindex;
  //     }else{
  //       $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
  //     }
  //    $date =$date1->subDays($weekly-1);

  // dd($date);

    
    $min=Load::where('user_id',Auth::user()->main)->where('user_id',Auth::user()->main)->get()->min('started_at');

    $mincache=Cache::where('user_id',Auth::user()->main)->get()->min('started_at');
    $caches=Cache::where('user_id',Auth::user()->main)->get();
    $admin=Admin::where('user_id',Auth::user()->main)->get();
    
    $start_time=Carbon::today();
    if($mincache<=$min || count($caches)==0){
            $main=Admin::where('user_id',Auth::user()->main)->get();
      $date1 = new Carbon($min);
      $date1->hour   = 0;
      $date1->minute = 0;
      $date1->second = 0;

      $dayOfTheWeek = $date1->dayOfWeek;
      if(($dayOfTheWeek-$main[0]->weekindex)>0){
        $weekly=$dayOfTheWeek-$main[0]->weekindex;
      }else{
        $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
      }
     $date =$date1->subDays($weekly-1);

     $diff= abs($start_time->diffInDays($date, false));
for ($i=0; $i <= $diff; $i=$i+7) { 
  $start=clone $date;
  $end= clone $date->addDays(6);
  $end->hour   = 23;
      $end->minute = 59;
      $end->second = 59;
   if(count($caches->where('started_at',$start))==0){
     
    $c_cache=new Cache();
    $c_cache->started_at =$start;
    $c_cache->ended_at =$end;
    $c_cache->weekindex =$admin[0]->weekindex ;
    $c_cache->dispatch_fee =$admin[0]->dispatch_fee ;
    $c_cache->permile =$admin[0]->permile ;
    $c_cache->insurance =$admin[0]->insurance ;
    $c_cache->eld =$admin[0]->eld ;
    $c_cache->ifta =$admin[0]->ifta ;
    $c_cache->lease =$admin[0]->lease ;
    $c_cache->user_id = Auth::user()->main;
    $c_cache->save();
   }
   $date->addDays(1);
} }else{
  
}


}

public function showcompany1()
{
  $this->checker();
  $caches_n=count(Cache::where('user_id',Auth::user()->main)->get());
   // <<  ٱلْحَمْدُ لِلَّٰهِ Alhamdulillah‎ >>
  $admin=Admin::where('user_id',Auth::user()->main)->get();
  $driver=Driver::where('user_id',Auth::user()->main)->get();
  $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
  if(($dayOfTheWeek-$admin[0]->weekindex)>0){
    $weekly=$dayOfTheWeek-$admin[0]->weekindex;
  }else{
    $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
  }
  $date = \Carbon\Carbon::today() ->subDays($weekly-1);
    $load = Load::where('user_id',Auth::user()->main)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
  $fuel = Fuel::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
  $recurring = Recurring::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
  $deduction = Deduction::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
  return view('driverreport.companyreport')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('drivers',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',1);
}

public function showcompany2(Request $request)
{
  $this->checker();
  $caches_n=count(Cache::where('user_id',Auth::user()->main)->get());
  // <<  ٱلْحَمْدُ لِلَّٰهِ Alhamdulillah‎ >>
  if($request['selection']==1){
    $admin=Admin::where('user_id',Auth::user()->main)->get();
    $driver=Driver::where('user_id',Auth::user()->main)->get();
    $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
    if(($dayOfTheWeek-$admin[0]->weekindex)>0){
      $weekly=$dayOfTheWeek-$admin[0]->weekindex;
    }else{
      $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
    }
    $date = \Carbon\Carbon::today() ->subDays($weekly-1);
    
    $load = Load::where('user_id',Auth::user()->main)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
  $fuel = Fuel::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
  $recurring = Recurring::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
  $deduction = Deduction::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
  return view('driverreport.companyreport')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('drivers',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',$request['selection']);
  
  }else{
  
    
   $main=Admin::where('user_id',Auth::user()->main)->get();
   $driver=Driver::where('user_id',Auth::user()->main)->get();
    $dayOfTheWeek = \Carbon\Carbon::now()->dayOfWeek;
    if(($dayOfTheWeek-$main[0]->weekindex)>0){
      $weekly=$dayOfTheWeek-$main[0]->weekindex;
    }else{
      $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
    }

    $date = \Carbon\Carbon::today() ->subDays(7*($request['selection']-1)+$weekly-1);
   
    $admin=Cache::where('user_id',Auth::user()->main)->where('started_at',$date)->get();

    
   
    $load = Load::where('user_id',Auth::user()->main)->where('ended_at','>=',$admin[0]->started_at)->where('ended_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
  $fuel = Fuel::where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
  $recurring = Recurring::where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
  $deduction = Deduction::where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
  return view('driverreport.companyreport')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('drivers',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',$request['selection']);
  }



  
  
}

public function sortByDate(Request $request){
  $main=Admin::where('user_id',Auth::user()->main)->get();
  
  $dateselected = new Carbon($request['dateselect']);
  $dayOfTheWeek = $dateselected->dayOfWeek;
    if(($dayOfTheWeek-$main[0]->weekindex)>0){
      $weekly=$dayOfTheWeek-$main[0]->weekindex;
    }else{
      $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
    }
    
    $date = $dateselected ->subDays($weekly-1);
    $date->hour   = 0;
    $date->minute = 0;
    $date->second = 0;

    $cached=Cache::where('user_id',Auth::user()->main)->where('started_at',$date)->get();
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(count($cached)==0){
     
      $this->checker();
      $caches_n=count(Cache::where('user_id',Auth::user()->main)->get());
       // <<  ٱلْحَمْدُ لِلَّٰهِ Alhamdulillah‎ >>
      $admin=Admin::where('user_id',Auth::user()->main)->get();
      $driver=Driver::where('user_id',Auth::user()->main)->get();
      $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
      if(($dayOfTheWeek-$admin[0]->weekindex)>0){
        $weekly=$dayOfTheWeek-$admin[0]->weekindex;
      }else{
        $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
      }
      $date = \Carbon\Carbon::today() ->subDays($weekly-1);
        $load = Load::where('user_id',Auth::user()->main)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $fuel = Fuel::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $recurring = Recurring::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $deduction = Deduction::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      return view('driverreport.companyreport')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('drivers',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',1);


    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////
    $caches=Cache::where('user_id',Auth::user()->main)->orderBy('started_at','desc')->get();
    for($i=0;$i<=count($caches)-1;$i++){
      if($caches[$i]->id == $cached[0]->id ){
       $number=$i+1;
      }
    }

    $request['selection']=$number;
   
  

//// This is part of company 2

              $this->checker();
              $caches_n=count(Cache::where('user_id',Auth::user()->main)->get());
              // <<  ٱلْحَمْدُ لِلَّٰهِ Alhamdulillah‎ >>
              if($request['selection']==1){
                    $admin=Admin::where('user_id',Auth::user()->main)->get();
                    $driver=Driver::where('user_id',Auth::user()->main)->get();
                    $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
                    if(($dayOfTheWeek-$admin[0]->weekindex)>0){
                      $weekly=$dayOfTheWeek-$admin[0]->weekindex;
                    }else{
                      $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
                    }
                    $date = \Carbon\Carbon::today() ->subDays($weekly-1);
                    
                    $load = Load::where('user_id',Auth::user()->main)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
                  $fuel = Fuel::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                  $recurring = Recurring::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                  $deduction = Deduction::where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
                  return view('driverreport.companyreport')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('drivers',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',$request['selection']);

              }else{

                    
                  $main=Admin::where('user_id',Auth::user()->main)->get();
                  $driver=Driver::where('user_id',Auth::user()->main)->get();
                    $dayOfTheWeek = \Carbon\Carbon::now()->dayOfWeek;
                    if(($dayOfTheWeek-$main[0]->weekindex)>0){
                      $weekly=$dayOfTheWeek-$main[0]->weekindex;
                    }else{
                      $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
                    }

                    $date = \Carbon\Carbon::today() ->subDays(7*($request['selection']-1)+$weekly-1);
                  
                    $admin=Cache::where('user_id',Auth::user()->main)->where('started_at',$date)->get();

                    
                  
                    $load = Load::where('user_id',Auth::user()->main)->where('ended_at','>=',$admin[0]->started_at)->where('ended_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                  $fuel = Fuel::where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                  $recurring = Recurring::where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                  $deduction = Deduction::where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
                  return view('driverreport.companyreport')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('drivers',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',$request['selection']);
              }
///end
            }

public function sortByDateDrivers(Request $request, $id){
  $main=Admin::where('user_id',Auth::user()->main)->get();
  
  $dateselected = new Carbon($request['dateselect']);
  $dayOfTheWeek = $dateselected->dayOfWeek;
    if(($dayOfTheWeek-$main[0]->weekindex)>0){
      $weekly=$dayOfTheWeek-$main[0]->weekindex;
    }else{
      $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
    }
    
    $date = $dateselected ->subDays($weekly-1);
    $date->hour   = 0;
    $date->minute = 0;
    $date->second = 0;

    $cached=Cache::where('started_at',$date)->get();
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
    if(count($cached)==0){
     
      $this->checker();
      $caches_n=count(Cache::where('user_id',Auth::user()->main)->get());
      // <<  ٱلْحَمْدُ لِلَّٰهِ Alhamdulillah‎ >>
  $admin=Admin::where('user_id',Auth::user()->main)->get();
  $driver=Driver::find($id);
  $dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
  if(($dayOfTheWeek-$admin[0]->weekindex)>0){
    $weekly=$dayOfTheWeek-$admin[0]->weekindex;
  }else{
    $weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
  }
  $date = \Carbon\Carbon::today() ->subDays($weekly-1);
        $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      $deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
      return view('driverreport.reports')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',1);

    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////
    $caches=Cache::where('user_id',Auth::user()->main)->orderBy('started_at','desc')->get();
    for($i=0;$i<=count($caches)-1;$i++){
      if($caches[$i]->id == $cached[0]->id ){
       $number=$i+1;
      }
    }

    $request['selection']=$number;
   
  

//// This is part of company 2

$caches_n=count(Cache::where('user_id',Auth::user()->main)->get());
$this->checker();
if($request['selection']==1){
// <<  ٱلْحَمْدُ لِلَّٰهِ Alhamdulillah‎ >>
$admin=Admin::where('user_id',Auth::user()->main)->get();
$driver=Driver::find($id);
$dayOfTheWeek = \Carbon\Carbon::today()->dayOfWeek;
if(($dayOfTheWeek-$admin[0]->weekindex)>0){
$weekly=$dayOfTheWeek-$admin[0]->weekindex;
}else{
$weekly=$dayOfTheWeek+(7-$admin[0]->weekindex);
}
$date = \Carbon\Carbon::today() ->subDays($weekly-1);
  $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('ended_at','>=',$date)->orderBy('created_at', 'desc')->get();
$fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
$recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
$deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$date)->orderBy('created_at', 'desc')->get();
return view('driverreport.reports')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',$request['selection']);
}else{

  
 $main=Admin::where('user_id',Auth::user()->main)->get();
  $driver=Driver::find($id);
  $dayOfTheWeek = \Carbon\Carbon::now()->dayOfWeek;
  if(($dayOfTheWeek-$main[0]->weekindex)>0){
    $weekly=$dayOfTheWeek-$main[0]->weekindex;
  }else{
    $weekly=$dayOfTheWeek+(7-$main[0]->weekindex);
  }

  $date = \Carbon\Carbon::today() ->subDays(7*($request['selection']-1)+$weekly-1);
 
  $admin=Cache::where('user_id',Auth::user()->main)->where('started_at',$date)->get();

  
 
  $load = Load::where('user_id',Auth::user()->main)->where('driver_id',$id)->where('ended_at','>=',$admin[0]->started_at)->where('ended_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
$fuel = Fuel::where('driver_id',$id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
$recurring = Recurring::where('driver_id',$id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
$deduction = Deduction::where('driver_id',$id)->where('created_at','>=',$admin[0]->started_at)->where('created_at','<=',$admin[0]->ended_at)->orderBy('created_at', 'desc')->get();
return view('driverreport.reports')->with("fuels",$fuel)->with("recurrings",$recurring)->with("deductions",$deduction)->with('driver',$driver)->with("loads",$load)->with("admin",$admin[0])->with('caches',$caches_n)->with('selected',$request['selection']);
}

///end







}





}
