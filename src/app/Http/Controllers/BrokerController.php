<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Load;
use App\Driver;
use App\User;
use App\Truck;
use App\Broker;
use Auth;
use Illuminate\Support\Facades\Validator;

class BrokerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brokers=Broker::where('user_id',Auth::user()->main)->orderBy('created_at', 'desc')->get();
        return view('broker.index')->with("brokers",$brokers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('broker.addbroker');
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
            'fax' => 'min:10',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'mc' => 'max:10',
            'dot' => 'max:15',  
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }
      

        $Broker=new Broker();
        $Broker->name = $request['name'];
        $Broker->address = $request['address'];
        $Broker->fax = $request['fax'];
        $Broker->email = $request['email'];
        $Broker->phone = $request['phone'];
        $Broker->mc = $request['mc'];
        $Broker->dot = $request['dot'];
        $Broker->user_id = Auth::user()->main;
        $Broker->save();

        $brokers=Broker::where('user_id',Auth::user()->main)->orderBy('created_at', 'desc')->get();
        return view('broker.index')->with("brokers",$brokers);
    }

    public function addBroker(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'address' => 'required|min:5',
            'fax' => 'min:10',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'mc' => 'max:10',
            'dot' => 'max:15',  
        ]);
        
        if($validator->fails()){
            return $validator->errors()->toJson();
        }
      

        $Broker=new Broker();
        $Broker->name = $request['name'];
        $Broker->address = $request['address'];
        $Broker->fax = $request['fax'];
        $Broker->email = $request['email'];
        $Broker->phone = $request['phone'];
        $Broker->mc = $request['mc'];
        $Broker->dot = $request['dot'];
       $Broker->save();
        $banan=array(
            'response' => "success",
            'id'=> $Broker->id,
            'name'=>$Broker->name
        );
        return json_encode($banan);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     
        $broker=Broker::find($id);
        return view('broker.addbroker')->with("broker",$broker);
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
            'fax' => 'min:10',
            'email' => 'required|email',
            'phone' => 'required|min:10',
            'mc' => 'required|min:4|max:10',
            'dot' => 'min:4|max:15',  
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }
      
        $Broker=Broker::find($id);
        $Broker->name = $request['name'];
        $Broker->address = $request['address'];
        $Broker->fax = $request['fax'];
        $Broker->email = $request['email'];
        $Broker->phone = $request['phone'];
        $Broker->mc = $request['mc'];
        $Broker->dot = $request['dot'];
        $Broker->user_id = Auth::user()->main;
        $Broker->save();

        $brokers=Broker::where('user_id',Auth::user()->main)->orderBy('created_at', 'desc')->get();
        return view('broker.index')->with("brokers",$brokers);
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $broker=Broker::find($id);
        $broker->delete();
        $brokers=Broker::where('user_id',Auth::user()->main)->orderBy('created_at', 'desc')->get();
                return view('broker.index')->with("brokers",$brokers);
    }
}
