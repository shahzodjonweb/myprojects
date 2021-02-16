<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use App\Locator;
use App\Load;
use Validator;
use JWTAuth;
use Config;

class ApiController extends Controller
{
  
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        Config::set('jwt.user', Driver::class);
    Config::set('auth.providers', ['users' => [
            'driver' => 'eloquent',
            'model' => Driver::class,
        ]]);
        $this->middleware('auth:api', ['except' => []]);
    }


    public function getLocation(Request $request){
        $validator = Validator::make($request->all(), [
            'loadid' => 'required',
            'stop' => 'integer|min:6',
            'type' => 'string|min:2',
            'lat' => 'required|string|min:2',
            'lon' => 'required|string|min:2',
            'time' => 'required|date',
        ]);
       
       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
 
        $driver_id=JWTAuth::user()->id;
        $location= new Locator;
        $location->load_id= $request['load_id'];
        $location->driver_id=$driver_id;
        $location->lat= $request['lat'];
        $location->lon= $request['lon'];
        $location->time= $request['time'];
        $location->stop= $request['stop'];
        $location->type= $request['type'];
        $location -> save();

        return response()->json(['success' => 1]);
    }
    public function getLoad(Request $request){
        $validator = Validator::make($request->all(), [
            'loadid' => 'required'
        ]);
       
       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
 
        $driver_id=JWTAuth::user()->id;
        $load=Load::find($request['loadid']);
        
        if($load){
            if($load->driver_id==$driver_id){
                return response()->json(['success' => 1,'load' => $load]);
                return $load;
            }else{
                return response()->json(['error' => 'Not Hackable :)'], 401);
            }
        }else{
            return response()->json(['error' => 'Load not found'], 404);
        }
    
    }
    public function getLoadList(){
        $driver_id=JWTAuth::user()->id;
        $loads=Load::where('driver_id',$driver_id)->orderBy('started_at', 'desc')->paginate(10);
        return response()->json(['success' => 1,'loadlist' => $loads]);
    }

    public function changeLoad(Request $request){
        $validator = Validator::make($request->all(), [
            'loadid' => 'required',
            'status' => 'required|string'
        ]);
       
       
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
 
        $driver_id=JWTAuth::user()->id;
        $load=Load::find($request['loadid']);
        $load->status = $request['status'];
        $load->update();

        return response()->json(['success' => 1,'loadlist' => $load]);

    }
    // public function getLocation(){
        
    // }
  

}
