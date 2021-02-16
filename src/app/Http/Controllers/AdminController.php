<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Load;
use App\Driver;
use App\User;
use App\Truck;
use App\Broker;
use App\Admin;
use Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register_user(Request $request){
        $user=new User();
        $user->name=$request['name'];
        $user->phone=$request['phone'];
        $user->email=$request['email'];
        $user->password=bcrypt($request['password']);
        $user->driver_password=$request['driver_password'];
        $user->role='admin';
        $user->save();

        $id=$user->id;
        
        $user1=User::find($id);
       
        $user1->main=$id;
        $user1->update();
        $user2=new User();
        $user2->name=$request['name'];
        $user2->password=bcrypt($request['dispatch_password']);
        $user2->phone=$request['phone'];
        $user2->email=$request['d_email'];
        $user2->role='dispatcher';
        $user2->main=$id;
        $user2->save();

        $admin=new Admin();
        $admin-> name = '';
        $admin-> logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJQAAAB7CAYAAACSLqmDAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAQcSURBVHhe7d1RS1RRFIbh/v9/6SKhQETI8MIEEyzwIi+UjAQFbyrKm6ktHZDpO+PM7O+cs9bZ78UDobPPWm7fjFDwxa/fDwvAhaBgRVCwIihYERSsCApWBAUrgoIVQcGKoGBFULAiKFgRFKwIClYEBSuCghVBwYqgYEVQsCIoWBEUrNIGdXt3vzg8Pl3s7B4sXr7en4zarbz9zf7h4v2HT4vvP37K18xVyqBKTMuf2Kmo/Z6+vwRf9lWvm6OUQZWvTE8/aVNS+y2/pqWoUga1/Amb0rr7tRIVQVXaZL8WoiKoSpvuN/eoCKrSNvvNOSqCqrTtfnONiqAq1ew3x6gIqlLtfnOLiqAqOfabU1QEVcm131yiIqhKzv1KVNm/90dQldz77b07Sh0VQVUaYr/MURFUpaH2yxoVQVUacr+MURFUpaH3Ozr5KGdERVCVht6v/OSnmhEVQVUaYz81IyqCqqT2axlBVVL7tYygKl1df5M7toqgKpX/2qsdW0VQBiWqq+ub9N+HcyCoBNQdREVQCag7iIqgElB3EBVBJaDuICqCSkDdQVQElYC6g6gIKgF1B1ERVALqDqIiqATUHURFUAmoO4iKoNZwdv758dsqRfmzes2Q1B1ERVDPuLj88t/88jb12qEsz4+MoFZQMXXGjErNj4qgeqyKqTNWVGp2VAQlrBNTZ4yo1NyoCGrJJjF1ho5KzYyKoJ7YJqbOkFGpeVER1D81MXWGikrNioqg/nLE1BkiKjUnquaDcsbUcUelZkTVdFBDxNRxRqWeH1WzQQ0ZU8cVlXp2VE0GNUZMHUdU6rlRNRfUmDF1aqNSz4yqqaCmiKlTE5V6XlTNBDVlTJ1to1LPiqqJoE7OzuVzplB2UTuuop4TVRNBfb25lc+ZQtlF7biKek5UfIUaGV+hAlKX/pzzi0v5rDGVHdRuz1HPiqqZoDal5irqrJuaGxVB9VBzFXXWTc2NiqB6qLmKOuum5kZFUD3UXEWddVNzoyKoHmquos66qblREVQPNVdRZ93U3KgIqoeaq6izbmpuVATVQ81V1Fk3NTcqguqh5irqrJuaGxVB9VBzFXXWTc2NiqB6qLmKOuum5kZFUD3UXEWddVNzoyKoHmquos66qblREVSPdX6GqvwmKnXWTc2OiqB67OwePP5CIDW/KO8rr1Fn3dT8qAgqAXUHURFUAuoOoiKoBNQdREVQCag7iIqgElB3EBVBJaDuICqCCu7V7lt5B1GlDOrw+FRe/hyVj1XdQVQpg7q9u5eXP0flY1V3EFXKoIpy0eVvb/knQX0iMisfU/nYssVUpA0KMREUrAgKVgQFK4KCFUHBiqBgRVCwIihYERSsCApWBAUrgoIVQcGKoGBFULAiKFgRFKwIClYEBSuCghVBwehh8QeGVnCcdmVUEAAAAABJRU5ErkJggg=='; 
        $admin-> invoicenumber = '20210000';

        $admin-> weekindex = 5;
        $admin-> dispatch_fee = 12;
        $admin-> permile = 0.65;
        $admin-> insurance = 310;
        $admin-> eld = 15;
        $admin-> ifta = 35;
        $admin-> lease = 700;
        $admin-> user_id = $id;
        $admin-> save();
        Auth::loginUsingId($id);
        return view('admin.index')->with("admin",$admin);
    }
    public function index()
    {
        $admin=Admin::where('user_id',Auth::user()->main)->get();
        if(count($admin)==0){
            $admin=new Admin();
            $admin-> name = '';
            $admin-> logo = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJQAAAB7CAYAAACSLqmDAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAAAQcSURBVHhe7d1RS1RRFIbh/v9/6SKhQETI8MIEEyzwIi+UjAQFbyrKm6ktHZDpO+PM7O+cs9bZ78UDobPPWm7fjFDwxa/fDwvAhaBgRVCwIihYERSsCApWBAUrgoIVQcGKoGBFULAiKFgRFKwIClYEBSuCghVBwYqgYEVQsCIoWBEUrNIGdXt3vzg8Pl3s7B4sXr7en4zarbz9zf7h4v2HT4vvP37K18xVyqBKTMuf2Kmo/Z6+vwRf9lWvm6OUQZWvTE8/aVNS+y2/pqWoUga1/Amb0rr7tRIVQVXaZL8WoiKoSpvuN/eoCKrSNvvNOSqCqrTtfnONiqAq1ew3x6gIqlLtfnOLiqAqOfabU1QEVcm131yiIqhKzv1KVNm/90dQldz77b07Sh0VQVUaYr/MURFUpaH2yxoVQVUacr+MURFUpaH3Ozr5KGdERVCVht6v/OSnmhEVQVUaYz81IyqCqqT2axlBVVL7tYygKl1df5M7toqgKpX/2qsdW0VQBiWqq+ub9N+HcyCoBNQdREVQCag7iIqgElB3EBVBJaDuICqCSkDdQVQElYC6g6gIKgF1B1ERVALqDqIiqATUHURFUAmoO4iKoNZwdv758dsqRfmzes2Q1B1ERVDPuLj88t/88jb12qEsz4+MoFZQMXXGjErNj4qgeqyKqTNWVGp2VAQlrBNTZ4yo1NyoCGrJJjF1ho5KzYyKoJ7YJqbOkFGpeVER1D81MXWGikrNioqg/nLE1BkiKjUnquaDcsbUcUelZkTVdFBDxNRxRqWeH1WzQQ0ZU8cVlXp2VE0GNUZMHUdU6rlRNRfUmDF1aqNSz4yqqaCmiKlTE5V6XlTNBDVlTJ1to1LPiqqJoE7OzuVzplB2UTuuop4TVRNBfb25lc+ZQtlF7biKek5UfIUaGV+hAlKX/pzzi0v5rDGVHdRuz1HPiqqZoDal5irqrJuaGxVB9VBzFXXWTc2NiqB6qLmKOuum5kZFUD3UXEWddVNzoyKoHmquos66qblREVQPNVdRZ93U3KgIqoeaq6izbmpuVATVQ81V1Fk3NTcqguqh5irqrJuaGxVB9VBzFXXWTc2NiqB6qLmKOuum5kZFUD3UXEWddVNzoyKoHmquos66qblREVSPdX6GqvwmKnXWTc2OiqB67OwePP5CIDW/KO8rr1Fn3dT8qAgqAXUHURFUAuoOoiKoBNQdREVQCag7iIqgElB3EBVBJaDuICqCCu7V7lt5B1GlDOrw+FRe/hyVj1XdQVQpg7q9u5eXP0flY1V3EFXKoIpy0eVvb/knQX0iMisfU/nYssVUpA0KMREUrAgKVgQFK4KCFUHBiqBgRVCwIihYERSsCApWBAUrgoIVQcGKoGBFULAiKFgRFKwIClYEBSuCghVBwehh8QeGVnCcdmVUEAAAAABJRU5ErkJggg=='; 
            $admin-> invoicenumber = '20210000';

            $admin-> weekindex = 5;
            $admin-> dispatch_fee = 12;
            $admin-> permile = 0.65;
            $admin-> insurance = 310;
            $admin-> eld = 15;
            $admin-> ifta = 35;
            $admin-> lease = 700;
            $admin->user_id = Auth::user()->main;
            $admin-> save();
            return view('admin.index')->with("admin",$admin);
        }

        return view('admin.index')->with("admin",$admin[0]);
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
        //
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
       // dd($id);
        $admin=Admin::find($id);
        if(!empty($request['name'])){
            $admin-> name = $request['name'];
            $admin-> location = $request['address'];
            $admin-> phone = $request['phone'];
            $admin-> fax = $request['fax'];
            $admin-> email = $request['email'];
            if(!empty($request['imageUploadbase64'])){
                $admin-> logo = $request['imageUploadbase64'];
            }
            
            $admin-> bank = $request['bank'];
            $admin-> accounting = $request['accounting'];
            $admin-> routing = $request['routing'];
            $admin-> mc = $request['mc'];
            $admin-> dot = $request['dot'];
            $admin-> invoicenumber = $request['invoicenumber'];
        }
        

        if(!empty($request['weekindex'])){
            $admin-> weekindex = $request['weekindex'];
            $admin-> dispatch_fee = $request['dispatch_fee'];
            $admin-> permile = $request['permile'];
            $admin-> insurance = $request['insurance'];
            $admin-> eld = $request['eld'];
            $admin-> ifta = $request['ifta'];
            $admin-> lease = $request['lease'];
        }
       
    

        $admin-> update();
        
        $admin=Admin::where('user_id',Auth::user()->main)->get();
        return back();
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

    public function payment()
    {
        $admin=Admin::where('user_id',Auth::user()->main)->get();
        return view('admin.payment')->with("admin",$admin[0]);
    }
}
