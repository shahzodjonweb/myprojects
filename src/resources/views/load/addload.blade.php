@extends('layouts.pack.loads')
@section('content1')
<form  action="{{ route('load.store') }}" id="submitload"  enctype="multipart/form-data" method="post">
  @csrf
<div class="container ui-container">
  <h4 class="text-center font-weight-bold">Adding Load</h4>
  <hr>
  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
      <div class="row mt-3">
        <div class="form-group col">
          <input type="text" class="form-control" id="number" name="number" placeholder="Load Number" value="{{old('number')}}">
        </div>
        <div class="form-group col row">
          <label for="broker" class="col-form-label col-3 font-weight-bold">Broker</label>
          <div class="input-group col-8">
            <select class="custom-select form-control font-weight-bold" id="broker" name="broker">
              @foreach ($brokers as $broker)
            <option value="{{ $broker->id }}" class="font-weight-bold">{{ $broker->name }}</option>
            @endforeach
            </select>
            <div class="input-group-append">
              <button class="btn btn-success btn-sm" onclick="addBroker()" type="button">+Add</button>
            </div>
          </div>
          
        </div>
      </div>



      <div class="row mt-3">
        <div class="form-group col row">
          <label for="pickupDate" class="col-form-label col-3 font-weight-bold">Pickup Date</label>
          <div class="col-sm-9">
            <input type="date"  class="form-control " id="pickupDate" name="pickupDate" value="{{old('pickupDate')}}">
          </div>
        </div>
        <div class="form-group col">
          <div class="ui search" >
            <div class="ui icon input">
              <input class="prompt form-control" type="text" placeholder="Search countries..." id="pickupLocation" name="pickupLocation" value="{{old('pickupLocation')}}" >
            </div>
            <div class="results"></div>
          </div>
        </div>
      </div>
 {{-- Adding new reciever or shipper --}}
      <input type="hidden" name="lastid" id="lastid" value="1">

      <div class="moreproduct">
      
      </div>
      <div class="d-flex flex-row-reverse my-3">
        <button type="button" class="btn btn-danger deleteproduct mx-2 d-none" onclick="deleteProduct()">-Delete</button>
        <button type="button" class="btn btn-primary mx-2" onclick="addProduct()">+Add</button>
      </div>
 {{--End of Adding new reciever or shipper --}}
      <div class="row mt-3">
        <div class="form-group col row">
          <label for="deliveryDate" class="col-form-label col-3 font-weight-bold">Delivery Date</label>
          <div class="col-sm-9">
            <input type="datetime-local" class="form-control " id="deliveryDate" name="deliveryDate"  value="{{old('deliveryDate')}}">
          </div>
          
        </div>
        <div class="form-group col">
          <div class="ui search " >
            <div class="ui icon input">
              <input class="prompt" type="text" placeholder="Search countries..." id="deliveryLocation" name="deliveryLocation"   value="{{old('deliveryLocation')}}">
            </div>
            <div class="results"></div>
          </div>
         
        </div>
      </div>

      <div class="row mt-3 mb-5">
        <div class="row col-6">
            <label for="phone" class="col-form-label col-3 font-weight-bold">Milage (mile)</label>
            <div class="col-9">

              <div class="input-group ">
                <input type="number" class="form-control" aria-describedby="basic-addon2" id="milage" name="milage"  
                @if ($errors->count()>0)
                value="{{old('milage')}}"
                @else
                value="0"
                @endif>
                <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">miles</span>
                </div>
                <div class="input-group-append">
                  <button class="btn btn-success calculateButton" type="button" onclick="getLocation()"><i class="fas fa-calculator fa-2x text-light"></i></button>
                </div>
              </div>
            </div>
          </div>
          <div class="row col-6">
            <label for="dot" class="col-form-label col-3 font-weight-bold ml-3">Deadhead</label>
            <div class="col-8">

              <div class="input-group ">
                <input type="number" class="form-control" aria-describedby="basic-addon2" id="deadhead" name="deadhead"  
                @if ($errors->count()>0)
                value="{{old('deadhead')}}"
                @else
                value="0"
                @endif
                >
                <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2">miles</span>
                </div>
               
              </div>
            </div>
          </div>
      </div>

      <div class="row mt-3">
        <div class="row col">
          <label for="price" class="col-form-label col-3 font-weight-bold">Price</label>
          <div class="col-8">
            <div class="input-group">
              <div class="input-group-prepend ">
                <span class="input-group-text">$</span>
              </div>
              <input type="number" class="form-control" id="price" name="price" value="{{old('price')}}" >
              <div class="input-group-append">
                <span class="input-group-text">.00</span>
              </div>
            </div>
          </div>
        </div>
      
        <div class="form-group col row">
          <label for="driver" class="col-form-label col-3 font-weight-bold">Driver</label>
          <select class="form-control font-italic col-8" id="driver" name="driver">
            @foreach ($drivers as $driver)
            <option value="{{ $driver->id }}">{{ $driver->fullname }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group col row">
          <label for="status" class="col-form-label col-3 font-weight-bold">Status</label>
          <select class="form-control font-weight-bold col-8" id="status" name="status">
            <option value="inactive" class="text-warning font-weight-bold">Not Started</option>
            <option value="active" class="text-success font-weight-bold">Started</option>
            <option value="finished" class="text-info font-weight-bold">Finished</option>
            <option value="invoiced" class="text-primary font-weight-bold">Invoiced</option>
            <option value="canceled" class="text-danger font-weight-bold">Canceled</option>
          </select>
        </div>
       
      </div>
      <div class="row mt-3">
        <div class="form-group col">
          <textarea class="form-control" id="comment" name="comment" rows="2" placeholder="Comments here ...">{{old('price')}}</textarea>
        </div>
      </div>
      <hr>
      <div class="row mt-3">
        <div class="col-5 row">
          <label for="status" class="col-form-label col-3">Upload RC</label>
          <div class="col-9">
            <div class="custom-file ">
              <input type="file" class="custom-file-input" id="rc" name="rc" >
              <label class="custom-file-label" for="rc">Choose file</label>
            </div>
          </div>

       
        </div>

        <div class="form-group col-5 row ml-5">
          <label for="term" class="col-form-label col-2 font-weight-bold">Status</label>
          <select class="form-control font-weight-bold col-10" id="term" name="term">
            <option value="30" class="text-info font-weight-bold">Net 30</option>
            <option value="0" class="text-success font-weight-bold">Quick pay</option>
            <option value="60" class="text-secondary font-weight-bold">Net 60</option>
            <option value="90" class="text-secondary font-weight-bold">Net 90</option>
          </select>
        </div>
      
      

      </div>
      <div class="row d-flex flex-row-reverse justify-content-center">
        <button type="button" onclick="checker()" class="btn btn-primary mr-2 btn-block btn-lg mt-5 mb-3 w-50 font-weight-bold">Submit</button>
      </div>

</div>
</form>
@endsection

@section('js1')
<script>
  
// Cities
 $.ajax({
  url: "{{ URL::asset('cities.json') }}",
  cache: false,
  success: function(data){
   cities=[];
  city=data;
   for(i=0;i<city.length;i++){
    title={ title: city[i].zip_code+'|'+city[i].county+' '+city[i].city+' '+city[i].state };
    cities.push(title);
   }
   $('.ui.search')
  .search({
    source: cities
  });}
});


</script>
<script>

function addBroker(){
  $('#addBroker').removeClass('d-none');
    
}

function checkbroker(){
  var formValues= $('#submitbroker').serialize();
 
 $.post("{{ url('broker/addBroker') }}", formValues, function(data){
     // Display the returned data in browser
    data=JSON.parse(data);
    if(data.response=="success"){
      $('#submitbroker')[0].reset();
      $('#broker').append('<option value="'+data.id+'" selected> '+data.name+'</option>');  
      $('#addBroker').addClass('d-none');                               
    }else{
     
      text='<div class="alert alert-danger"><ul>';
       if(data.name){
        text+='<li>'+data.name+'</li>';
       }
       if(data.address){
        text+='<li>'+data.address+'</li>';
       }
       if(data.fax){
        text+='<li>'+data.fax+'</li>';
       }
       if(data.email){
        text+='<li>'+data.email+'</li>';
       }
       if(data.phone){
        text+='<li>'+data.phone+'</li>';
       }
       if(data.mc){
        text+='<li>'+data.mc+'</li>';
       }
       if(data.dot){
        text+='<li>'+data.dot+'</li>';
       }
     
                text+='</ul></div>';
                $('.alert-show-broker').html(text);
    }
 });

}

  function checker(){
    num = $('#lastid').val();
    if(!$('#pickupDate').val()){
            alert('Please set all dates for locations!');
            return;
          }

          for(i=1;i<num;i++){
          if(!$('#date'+i).val()){
            alert('Please set all dates for locations!');
            return;
          }

        }

        if(!$('#deliveryDate').val()){
            alert('Please set all dates for locations!');
            return;
          }

    if($('#pickupLocation').val()==''){
            alert('Please set all locations to submit!');
            return;
          }

          for(i=1;i<num;i++){
          if($('#location'+i).val()==''){
            alert('Please set all locations to submit!');
            return;
          }

        }

        if($('#deliveryLocation').val()==''){
            alert('Please set all locations to submit!');
            return;
          }

          if(!($('#pickupLocation').val().indexOf('|') > -1)){
            alert('Please select one of the location options!');
            $('#pickupLocation').val('');
            return;
          }

          for(i=1;i<num;i++){
          if(!($('#location'+i).val().indexOf('|') > -1)){
            alert('Please select one of the location options!');
            $('#location'+i).val('');
            return;
          }

        }

        if(!($('#deliveryLocation').val().indexOf('|') > -1)){
            alert('Please select one of the location options!');
            $('#deliveryLocation').val('');
            return;
          }

          setTimeout(() => {
            $('#submitload').submit();
          }, 300);
         

  }
  function getLocation(){
          num = $('#lastid').val(); 
          elements=Array(1);
          if($('#pickupLocation').val()==''){
            alert('Please set all locations to caculate!');
            return;
          }
          elements[0]=$('#pickupLocation').val();

        for(i=1;i<num;i++){
          if($('#location'+i).val()==''){
            alert('Please set all locations to caculate!');
            return;
          }
          elements.push($('#location'+i).val())

        }

        if($('#deliveryLocation').val()==''){
            alert('Please set all locations to caculate!');
            return;
          }
          $('.calculateButton').html('<div class="spinner-grow text-light" role="status"><span class="sr-only">Loading...</span></div>')
  elements.push($('#deliveryLocation').val())
    var locations=new Array();
    
      
          for (var index = 0; index <= elements.length; index++) {
           // locations.push(getLocVariables(elements[index]));
           (function(index) {
        setTimeout(function() { 
          if(index==(elements.length)){
            caculateDistance();
          }else{
            getLocVariables(elements[index],function(data) {         
            locations.push(data);           
           });
          }
        
        
           }, index * 700);
    })(index);
    
          }


        function  caculateDistance(){
          var milage=0;
          for (var i = 1; i <= locations.length+1; i++) {
            (function(i) {
        setTimeout(function() { 
          if(i==locations.length+1){ 
            $('#milage').val(milage);
            $('.calculateButton').html('<i class="fas fa-2x text-light fa-calculator"></i>')
          }else{
            if(i==locations.length){
              return;
            }
              calculateDistance(locations[i-1].lon,locations[i-1].lat,locations[i].lon,locations[i].lat,function(data) {
            milage+=parseInt(data);
    });
        
            
          }
           }, i * 700);
    })(i);


          }

          };

       
          

 
      
  
  }
  
   function getLocVariables(location,callback){
    //alert(location);
          location = location.replace("|", "+");
          
        var jsonrequest =
          "https://us1.locationiq.com/v1/search.php?key=pk.942d31fb7bef1b6ec5147e7742064206&q=" +
          location +
          "&format=json";
          var loc=new Array();
        
            $.post( jsonrequest, function( data ) {
          
            loc.lon=data[0].lon;
            loc.lat=data[0].lat;
            callback(loc);
          
              });
  
  }

   function calculateDistance(lon1,lat1,lon2,lat2,callback){

    setTimeout(() => {
      var dist;
    
      var string_request='https://us1.locationiq.com/v1/directions/driving/'+lon1+','+lat1+';'+lon2+','+lat2+'?key=pk.942d31fb7bef1b6ec5147e7742064206&overview=false';
     $.post( string_request, function( data ) {
          var dist = data.routes[0].distance;
        (dist = dist / 1609), 34;
        dist = dist.toFixed(0);
        callback(dist);
             });

  }, 500);
    

  }
  $('#rc').on('change',function(){
                //get the file name
                var fileName = $(this).val();
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html('...'+fileName.substr(fileName.length - 15));
            })
  function addProduct(){
var mainId=parseInt($('#lastid').val());
  htmlContent='<div class="pr'+mainId+' row mt-3"><div class="form-group col row">'
  +'<label for="pickupDate" class="col-form-label col-3 font-weight-bold">Location '+mainId+'</label><div class="col-sm-9">'
            +'<input type="datetime-local" class="form-control " id="date'+mainId+'" name="date'+mainId+'">'
  +'</div></div><div class="form-group col"><div class="ui search" ><div class="ui icon input">'
            +'<input class="prompt" type="text" placeholder="Search countries..." id="location'+mainId+'" name="location'+mainId+'" >'
  +'</div><div class="results"></div></div></div></div>';

   $('.moreproduct').append(htmlContent);
   $('#lastid').val(mainId+1);
   if(mainId>0){
    $('.deleteproduct').removeClass('d-none');
   }else{
    $('.deleteproduct').addClass('d-none');
   }

   $.ajax({
  url: "{{ URL::asset('cities.json') }}",
  cache: false,
  success: function(data){
   cities=[];
  city=data;
   for(i=0;i<city.length;i++){
    title={ title: city[i].zip_code+'|'+city[i].county+', '+city[i].city+' '+city[i].state };
    cities.push(title);
   }
   $('.ui.search')
  .search({
    source: cities
  });}
});
}
function deleteProduct(){
  var mainId=parseInt($('#lastid').val())-1;
  $('.pr'+mainId+'').remove();
  $('#lastid').val(mainId);
  if(mainId>1){
    $('.deleteproduct').removeClass('d-none');
   }else{
    $('.deleteproduct').addClass('d-none');
   }
}

</script>
<script>
  
    //var content = [];
      $('#tab-1').prop( "checked", false );
$('#tab-2').prop( "checked", true );
$('#tab-3').prop( "checked", false );


function setid(id){
   $('#dedas').val(id);
}

$("#driver").val({{old('driver')}}).change();
 $("#status").val("{{old('status')}}").change();
 $("#broker").val({{old('broker')}}).change();
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection