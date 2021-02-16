<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
         $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
        return view('dashboard.main')->with('activeDrivers',$activeDrivers)->with('restDrivers',$restDrivers);
    }
}
