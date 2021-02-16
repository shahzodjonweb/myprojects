<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Load;
use App\Driver;
use App\User;
use App\Truck;
use Auth;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
        $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
        $vacationDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"vacation")->get();
        $inactiveDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"deleted")->get();

        return view('drivers.driverlist')->with('activeDrivers',$activeDrivers)->with('vacationDrivers',$vacationDrivers)->with('inactiveDrivers',$inactiveDrivers)->with('restDrivers',$restDrivers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('drivers.adddriver');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'address' => 'required|min:5',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'comment' => 'max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }

        $d_password=User::find(Auth::user()->main);
        $pass=bcrypt($d_password->driver_password);
        if($request['type']=='team1'||$request['type']=='team1'){
            $driver=new Driver();
            $driver->fullname = $request['name'].' | '.$request['name1'];
            if($request['type']=='team1'){
                $driver->type = "company";
            }
            if($request['type']=='team2'){
                $driver->type = "owner";
            }
            
            if($request['type']=='team3'){
                $driver->type = "lease";
            }
            
            $driver->address = $request['address'];
            $driver->email = $request['email'].' | '.$request['email1'];
            $driver->phone = $request['phone'].' | '.$request['phone1'];
            $driver->status = $request['status'];
            $driver->comment = $request['comment'];
            $driver->team = true;
            $driver->password = $pass;
            $driver->user_id = Auth::user()->main;
            $driver->save();
        }else{
            $driver=new Driver();
            $driver->fullname = $request['name'];
            $driver->type = $request['type'];
            $driver->address = $request['address'];
            $driver->email = $request['email'];
            $driver->phone = $request['phone'];
            $driver->status = $request['status'];
            $driver->comment = $request['comment'];
            $driver->team = false;
            $driver->password = $pass;
            $driver->user_id = Auth::user()->main;
            $driver->save();
        }
        

        $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
        $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
        $vacationDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"vacation")->get();
        $inactiveDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"deleted")->get();

        session()->flash('success','Successfully saved!');
        return view('drivers.driverlist')->with('activeDrivers',$activeDrivers)->with('vacationDrivers',$vacationDrivers)->with('inactiveDrivers',$inactiveDrivers)->with('restDrivers',$restDrivers);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $driver=Driver::find($id);
        $loads=$driver->loads()->paginate(9);
        return view('drivers.driverloads')->with('driver',$driver)->with('loads',$loads);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $driver=Driver::find($id);
        return view('drivers.edit')->with('driver',$driver);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'address' => 'required|min:5',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'comment' => 'max:500',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }
        $driver=Driver::find($id);
        $driver->fullname = $request['name'];
        $driver->type = $request['type'];
        $driver->address = $request['address'];
        $driver->email = $request['email'];
        $driver->phone = $request['phone'];
        $driver->status = $request['status'];
        $driver->comment = $request['comment'];
        $driver->update();

        $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
        $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
        $vacationDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"vacation")->get();
        $inactiveDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"deleted")->get();

        session()->flash('success','Successfully saved!');
        return back()->with('activeDrivers',$activeDrivers)->with('vacationDrivers',$vacationDrivers)->with('inactiveDrivers',$inactiveDrivers)->with('restDrivers',$restDrivers);
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

    public function liveboard(){
        $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
         $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
        return view('dashboard.main')->with('activeDrivers',$activeDrivers)->with('restDrivers',$restDrivers);
    }
    public function changecomment(Request $request){
         $driver=Driver::find($request['comment_id']);
         $driver->comment= $request['comment'];
         $driver->update();
         $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
         $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
        return back();
    }

    public function deleteDriver(Request $request){
        $driver=Driver::find($request['id']);
        $driver->delete();

        $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
        $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
        $vacationDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"vacation")->get();
        $inactiveDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"deleted")->get();

        session()->flash('success','Successfully deleted!');
        return back()->with('activeDrivers',$activeDrivers)->with('vacationDrivers',$vacationDrivers)->with('inactiveDrivers',$inactiveDrivers)->with('restDrivers',$restDrivers);
    }

    public function changestatus(Request $request){
        // dd($request['load_id']);
         $driver=Driver::find($request['driver_id']);
         $driver->status= $request['status'];
         $driver->update();
         
         $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
         $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
         $vacationDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"vacation")->get();
         $inactiveDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"deleted")->get();
 
         session()->flash('success','Successfully deleted!');
         return back()->with('activeDrivers',$activeDrivers)->with('vacationDrivers',$vacationDrivers)->with('inactiveDrivers',$inactiveDrivers)->with('restDrivers',$restDrivers);
    
    }
   
}
