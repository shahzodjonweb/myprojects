@extends('layouts.pack.drivers')
@section('content1')
<div class="d-flex justify-content-center">
  <form  action="{{ route('driver.store') }}" enctype="multipart/form-data" method="post">
      @csrf
  <div class="ui-container ui-11w">
      <h4 class="text-center font-weight-bold">Creating Driver</h4>
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
            <div class="form-group col-6">
              <input type="text" class="form-control" id="name" name="name" placeholder="Fullname" value="{{ old('name') }}">
            </div>
            <div class="form-group col-6 row">
              <label for="type" class="col-form-label col-3 font-weight-bold">Type</label>
              <select class="form-control font-weight-bold col-8" id="type" name="type" onchange="checkdrivertype()">
                <option value="company" class="text-info font-weight-bold">Company Driver</option>
                <option value="owner" class="text-success font-weight-bold">Owner Driver</option>
                <option value="lease" class="text-warning font-weight-bold">Lease Driver</option>
                <option value="team1" class="text-primary font-weight-bold">Team Company Drivers</option>
                <option value="team2" class="text-primary font-weight-bold">Team Owner Drivers</option>
                <option value="team3" class="text-primary font-weight-bold">Team Lease Drivers</option>
              </select>
            </div>
          </div>


          <div class="row mt-3">
              <div class="row col-6">
                  <label for="phone" class="col-form-label col-3 font-weight-bold">Phone</label>
                  <div class="col-9">
                    <div class="input-group">
                      <div class="input-group-prepend ">
                        <span class="input-group-text">+1</span>
                      </div>
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="(123) 456-7890" oninput="formatnumber()" value="{{ old('phone') }}">
                    </div>
                  </div>
                 
                </div>
              <div class="form-group col-6">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
              </div>
            </div>
                {{-- //second driver info --}}
                <div class="secondD d-none">
            <div class="row mt-3">
              <div class="form-group col">
                <input type="text" class="form-control" id="name1" name="name1" placeholder="Fullname of Second Driver" value="{{ old('name1') }}">
              </div>
            
            </div>
            <div class="row mt-3">
                <div class="row col-6">
                    <label for="phone" class="col-form-label col-3 font-weight-bold">Phone</label>
                    <div class="col-9">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text">+1</span>
                        </div>
                        <input type="text" class="form-control" id="phone1" name="phone1" placeholder="(123) 456-7890" oninput="formatnumber2()" value="{{ old('phone1') }}">
                      </div>
                    </div>
                   
                  </div>
                <div class="form-group col-6">
                  <input type="email" class="form-control" id="email1" name="email1" placeholder="Email" value="{{ old('email1') }}">
                </div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="form-group col-6">
                <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ old('address') }}">
              </div>
              <div class="form-group col-6 row">
                  <label for="status" class="col-form-label col-3 font-weight-bold">Status</label>
                  <select class="form-control font-weight-bold col-8" id="status" name="status">
                    <option value="active" class="text-success font-weight-bold">Active</option>
                    <option value="vacation" class="text-warning font-weight-bold">Vacation</option>
                    <option value="rest" class="text-warning font-weight-bold">Rest</option>
                  </select>
                </div>
            </div>
            <div class="row mt-3">
              <div class="form-group col">
                <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Comments here ..." >{{ old('comment') }}</textarea>
              </div>
            </div>
            <div class="row d-flex flex-row-reverse justify-content-center">
              <button type="submit" class="btn btn-success mr-2 btn-block btn-lg mt-3 mb-3 w-50 font-weight-bold">Create</button>
            </div>
  </div>
  </form>
</div>
@endsection

@section('js1')
<script>
 function checkdrivertype(){
   if($('#type').val() =='team1'||$('#type').val() =='team2'||$('#type').val() =='team3' ){
    $('.secondD').removeClass('d-none');
   }else{
    $('.secondD').addClass('d-none');
   }
  
 }
function formatnumber(){
  phone=$('#phone').val();
  formatted=normalize(phone);
  if(formatted){
  $('#phone').val(formatted);
}
}
function formatnumber2(){
  phone=$('#phone1').val();
  formatted=normalize(phone);
  if(formatted){
  $('#phone1').val(formatted);
}
}
function normalize(phone) {
    //normalize string and remove all unnecessary characters
    phone = phone.replace(/[^\d]/g, "");

    //check if number length equals to 10
    if (phone.length == 10) {
        //reformat and return phone number
        return phone.replace(/(\d{3})(\d{3})(\d{4})/, "($1) $2-$3");
    }

    return null;
}

$("#type").val("{{ old('type')}}").change();
 $("#status").val("{{ old('status')}}").change();
</script>
<script>
  $('#tab-1').prop( "checked", false );
$('#tab-2').prop( "checked", true );
</script>
@endsection

@section('css1')
    <style>
    </style>
@endsection