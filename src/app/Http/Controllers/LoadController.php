<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Load;
use App\Driver;
use App\User;
use App\Truck;
use App\Shipper;
use App\Location;
use App\Broker;
use App\Admin;
use PDF;
use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class LoadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loads=Load::where('user_id',Auth::user()->main)->orderBy('started_at', 'desc')->paginate(9);
        return view('load.loadlist')->with("loads",$loads);
     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $drivers=Driver::where('user_id',Auth::user()->main)->get();
        $brokers=Broker::where('user_id',Auth::user()->main)->get();
        return view('dashboard.addload')->with('drivers',$drivers)->with('brokers',$brokers);
    }
    public function create2()
    {
        $drivers=Driver::where('user_id',Auth::user()->main)->get();
        $brokers=Broker::where('user_id',Auth::user()->main)->get();
        return view('load.addload')->with('drivers',$drivers)->with('brokers',$brokers);
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
            'broker' => 'required|exists:brokers,id',
            'number' => 'required|unique:loads,number',
            'price' => 'required|min:1|max:8',
            'milage' => 'required|min:1|max:6',
            'deadhead' => 'required|min:1|max:3',
            'status' => 'required',
            'term' => 'required',
            'driver' => 'required|exists:drivers,id',
            'pickupDate' => 'required|date',
            'deliveryDate' => 'required|date|after:pickupDate',
            'rc' => 'required|file',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }

        if($request->hasFile('rc')){
            $rc=$request->rc->store('rc');
        }else{
            $rc=0;
        }
        
        $load=new Load();
        $load->broker_id = $request['broker'];
        $load->number = $request['number'];
        $load->price = $request['price'];
        $load->milage = $request['milage'];
        $load->deadhead = $request['deadhead'];
        if($request['deadhead']<50){
            $load->deadhead_d =$request['deadhead'];
        }else{
            $load->deadhead_d =$request['deadhead'];
        }
        $load->detention = 0;
        $load->lumper = 0;
        $load->tonu = 0;
        $load->status = $request['status'];
        $load->comment = $request['comment'];
        $load->rc = $rc;
        $load->term =  $request['term'];
        $load->driver_id = $request['driver'];

        $load->started_at = $request['pickupDate'];
        $load->ended_at = $request['deliveryDate'];
        $load->user_id = Auth::user()->main;
        
        $load->save();
         $inc=1;
                    /// Creating shipper stops
        $shipper=new Shipper();
        $shipper->order = $inc;
        $shipper->type ="shipper";
        $position=strpos( $request['pickupLocation'], '|' );
        $checker=substr($request['pickupLocation'], 0, $position);
        $locationid=Location::where('zipcode',$checker)->get();
        $shipper->location_id=$locationid[0]->id;
        $shipper->load_id = $load->id;
        $shipper->time = $request['pickupDate'];
        
        $shipper->save();
          $inc++;
        if($request['lastid']>1){
            
            for($i=1;$i<$request['lastid'];$i++){
                
                $shipper=new Shipper();
                $shipper->order = $inc;
                $shipper->type ="reciever";
                $position=strpos( $request['location'.$i], '|' );
                $checker=substr($request['location'.$i], 0, $position);
                $locationid=Location::where('zipcode',$checker)->get();
                $shipper->location_id=$locationid[0]->id;
                $shipper->load_id = $load->id;
                $shipper->time = $request['date'.$i];
                $shipper->save();
                $inc++;
            }
          
        }

        $shipper=new Shipper();
        $shipper->order = ($inc);
        $shipper->type ="reciever";
        $position=strpos( $request['deliveryLocation'], '|' );
        $checker=substr($request['deliveryLocation'], 0, $position);
        $locationid=Location::where('zipcode',$checker)->get();
        $shipper->location_id=$locationid[0]->id;
        $shipper->load_id = $load->id;
        $shipper->time = $request['deliveryDate'];
        $shipper->save();

                /// End of Creating shipper stops
        

        session()->flash('success','Successfully saved!');
        return back();
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
        $drivers=Driver::where('user_id',Auth::user()->main)->get();
        $brokers=Broker::where('user_id',Auth::user()->main)->get();
        $load=Load::find($id);
        return view('load.edit')->with("load",$load)->with('drivers',$drivers)->with('brokers',$brokers);
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
            'broker' => 'required|exists:brokers,id',
            'number' => 'required',
            'price' => 'required|min:1|max:8',
            'milage' => 'required|min:1|max:6',
            'deadhead' => 'required|min:1|max:3',
            'status' => 'required',
            'term' => 'required',
            'driver' => 'required|exists:drivers,id',
            'pickupDate' => 'required|date',
            'deliveryDate' => 'required|date|after:pickupDate',
          
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput();
        }
      
         if(empty($request["tonu"])){
            $request["tonu"]=0;
         }
         if(empty($request["detention"])){
            $request["detention"]=0;
         }
         if(empty($request["lumper"])){
            $request["lumper"]=0;
         }
        $load=Load::find($id);

       

        $load->broker_id = $request['broker'];
        $load->number = $request['number'];
        // $load->pickup = $request['pickupLocation'];
        // $load->ptime = $request['pickupDate'];
        // $load->delivery = $request['deliveryLocation'];
        // $load->dtime = $request['deliveryDate'];
        $load->price = $request['price'];
        $load->milage = $request['milage'];
        $load->deadhead = $request['deadhead'];
        if($request['deadhead']<50){
            $load->deadhead_d =$request['deadhead'];
        }else{
            $load->deadhead_d =$request['deadhead'];
        }
       
        $load->detention = $request['detention'];
        $load->lumper = $request['lumper'];
        $load->tonu = $request['tonu'];
        $load->status = $request['status'];
        $load->comment = $request['comment'];

        $load->started_at = $request['pickupDate'];
        $load->ended_at = $request['deliveryDate'];


        if($request->hasFile('rc')){
            Storage::delete($load->rc);
            $rc=$request->rc->store('rc'); 
            $load->rc = $rc;
        } 
        if($request->hasFile('bol')){
            Storage::delete($load->bol);
            $bol=$request->bol->store('bol');
            $load->bol = $bol;
        }

  

        $load->term =  $request['term'];
        $load->driver_id = $request['driver'];
        if($request['status']=='invoiced'){
            if($load->invoiced_at!=null){
                $now=$load->invoiced_at;
               
            }else{
         
             $now=date('Y-m-d H:i:s');
             $load->invoiced_at=$now;
             
            }
          //  dd( $now);
            $term=$request['term']; 
         $load->term=$term; 
         if($term!=0){
             $load->deadline=date('Y-m-d H:i:s',strtotime('+'.$term.' days', strtotime($now))); 
         }
         $load->update();
         $load->invoice = $this->createPDF($load->id);
        }
        $load->update();

        $inc=1;
                   /// Creating shipper stops
                      $shipper=Shipper::find($request['id1']);
                      $shipper->order = $inc;
                      $shipper->type ="shipper";
                      $position=strpos( $request['pickupLocation'], '|' );
                      $checker=substr($request['pickupLocation'], 0, $position);
                      $locationid=Location::where('zipcode',$checker)->get();
                      $shipper->location_id=$locationid[0]->id;
                      $shipper->load_id = $load->id;
                      $shipper->time = $request['pickupDate'];
                      $shipper->update();
                        $inc++;
                    
                      if($request['lastid']>1){
                          
                          for($i=1;$i<$request['lastid'];$i++){
                              
                            $shipper=Shipper::find($request['id'.($i+1)]);
                          
                            if(empty($shipper)){
                                $shipper=new Shipper();
                                $shipper->order = $inc;
                                $shipper->type ="reciever";
                                $position=strpos( $request['location'.$i], '|' );
                                $checker=substr($request['location'.$i], 0, $position);
                               
                                $locationid=Location::where('zipcode',$checker)->get();
                                $shipper->location_id=$locationid[0]->id;
                                $shipper->load_id = $load->id;
                                $shipper->time = $request['date'.$i];
                                $shipper->save();
                                $inc++;
                            }else{
                                $shipper->order = $inc;
                                $shipper->type ="reciever";
                                $position=strpos( $request['location'.$i], '|' );
                                $checker=substr($request['location'.$i], 0, $position);
                              
                                $locationid=Location::where('zipcode',$checker)->get();
                                $shipper->location_id=$locationid[0]->id;
                                $shipper->load_id = $load->id;
                                $shipper->time = $request['date'.$i];
                              

                                $shipper->save();
                                $inc++;

                               
                            }
                            
                          }
                        
                      }
                    
                        
                      $shipper=Shipper::find($request['iddel']);
                    //   dd($request);
                        $shipper->order = $inc;
                        $shipper->type ="reciever";
                        $position=strpos( $request['deliveryLocation'], '|' );
                        $checker=substr($request['deliveryLocation'], 0, $position);
                        $locationid=Location::where('zipcode',$checker)->get();
                        $shipper->location_id=$locationid[0]->id;
                        $shipper->load_id = $load->id;
                        $shipper->time = $request['deliveryDate'];
                        $shipper->update();
                      
                     
                        $loads=Shipper::where('load_id',$load->id)->where('order','>',$inc)->get();
                      //   dd($loads);
                        foreach ($loads as $load) {
                            $load->delete();
                        }

                      
              
                              /// End of Creating shipper stops
        session()->flash('success','Successfully updated!');
        $loads=Load::where('user_id',Auth::user()->main)->orderBy('started_at', 'desc')->paginate(9);
        return view('load.loadlist')->with("loads",$loads);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
    public function liveboard(){
        $loads=Load::where('user_id',Auth::user()->main)->orderBy('started_at', 'desc')->whereIn("status",["active","inactive"])->paginate(9);
        return view('dashboard.loadlist')->with("loads",$loads);
    }
    public function changestatus(Request $request){
       // dd($request['load_id']);
        $load=Load::find($request['load_id']);
        $load->status= $request['status'];
        $load->update();
        $restDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"rest")->get();
        $activeDrivers=Driver::where('user_id',Auth::user()->main)->where('status',"active")->get();
       return view('dashboard.main')->with('activeDrivers',$activeDrivers)->with('restDrivers',$restDrivers);
   }
   public function deleteLoad(Request $request){
    $load=Load::find($request['id']);
    $load->delete();
    $loads=Load::where('user_id',Auth::user()->main)->orderBy('started_at', 'desc')->get();
    return back()->with("loads",$loads);
   }

   public function createPDF($id) {
   
   $load=Load::find($id);
    $admin=Admin::where('user_id',Auth::user()->main)->get()[0];
    $pdf = PDF::loadView('invoice', ['load' => $load,'admin'=>$admin]);
    // download PDF file with download method
    $content='invoice/'.md5("generate_invoice". microtime()).'.pdf';
        if(!empty($load->invoice)){
            Storage::delete($load->invoice);
        }
        $number=$admin->invoicenumber+1;
        $admin->invoicenumber =$number;
        $admin->update();
    Storage::put($content, $pdf->output());
    //return $pdf->download('pdf_file.pdf');
    return $content;
   
  }

  public function getLocation(Request $request){
      $zips=[];
      for($i=0;$i<count($request['locations']);$i++){
        $position=strpos( $request['locations'][$i], '|' );
        $checker=substr($request['locations'][$i], 0, $position);
        $zips[$i]=$checker;
      }
   $location=Location::wherein('zipcode',$zips)->get();
   $string_request='';
   for($n=0;$n<count($location);$n++){
       if($n==(count($location)-1)){
        $string_request.=$location[$n]->longitude.','.$location[$n]->latitude;
        continue;
       }
    $string_request.=$location[$n]->longitude.','.$location[$n]->latitude.';';
   }
   
   return $string_request;

}
 

    public function searchload(Request $request,$type){
        switch ($type) {
            case 'many':
                $result=Load::where('user_id',Auth::user()->main)->orderBy('started_at', 'desc');

                if(!(empty($request['date1'])||empty($request['date2'])))   {
                    if($request['date1']<=$request['date2']){         
                        $result= $result->whereBetween('started_at', [$request['date1'], $request['date2']]);
                    }
                }
                
                if(!(empty($request['date1']))&&empty($request['date2']))   {
                        $result= $result->where('started_at','>=', $request['date1']);
                }
                if(!(empty($request['date2']))&&empty($request['date1']))   {
                    $result= $result->where('started_at','<=', $request['date2']);
            }

            if(!(empty($request['rate1'])||empty($request['rate2'])))   {
                if($request['rate1']<=$request['rate2']){
                    $result= $result->whereBetween('price', [$request['rate1'], $request['rate2']]);
                }
            }
            if(!(empty($request['rate1']))&&empty($request['rate2']))   {
                    $result= $result->where('price','>=', $request['rate1']);
            }
            if(!(empty($request['rate2']))&&empty($request['rate1']))   {
                $result= $result->where('price','<=', $request['rate2']);
        }
        if(!empty($request['status']))   {
            $result= $result->where('status', $request['status']);
    }
    
                $result=$result->paginate(9);
                return view($request['page'])->with("loads",$result)->with("search",$request);
                break;


//////////////////////////////////////////////////////////////////////////////////////////////////////////

                case 'live':
                    $result=Load::where('user_id',Auth::user()->main)->orderBy('started_at', 'desc')->whereIn("status",["active","inactive"]);
    
                    if(!(empty($request['date1'])||empty($request['date2'])))   {
                        if($request['date1']<=$request['date2']){         
                            $result= $result->whereBetween('started_at', [$request['date1'], $request['date2']]);
                        }
                    }
                    
                    if(!(empty($request['date1']))&&empty($request['date2']))   {
                            $result= $result->where('started_at','>=', $request['date1']);
                    }
                    if(!(empty($request['date2']))&&empty($request['date1']))   {
                        $result= $result->where('started_at','<=', $request['date2']);
                }
    
                if(!(empty($request['rate1'])||empty($request['rate2'])))   {
                    if($request['rate1']<=$request['rate2']){
                        $result= $result->whereBetween('price', [$request['rate1'], $request['rate2']]);
                    }
                }
                if(!(empty($request['rate1']))&&empty($request['rate2']))   {
                        $result= $result->where('price','>=', $request['rate1']);
                }
                if(!(empty($request['rate2']))&&empty($request['rate1']))   {
                    $result= $result->where('price','<=', $request['rate2']);
            }
            if(!empty($request['status']))   {
                $result= $result->where('status', $request['status']);
        }
        
                    $result=$result->paginate(9);
                    return view($request['page'])->with("loads",$result)->with("search",$request);
                    break;


////////////////////////////////////////////////////////////////////////////////////////////////////////////

                    case 'unit':
                        $result=Load::where('user_id',Auth::user()->main)->orderBy('started_at', 'desc')->where('number',  'LIKE', "%{$request['l_number']}%")->paginate(9);
        return view($request['page'])->with("loads",$result)->with("search",$request);
                        break;
            
            default:
            $loads=Load::where('user_id',Auth::user()->main)->orderBy('started_at', 'desc')->paginate(9);
            return view('load.loadlist')->with("loads",$loads);
                break;
        }
        
    }

}
