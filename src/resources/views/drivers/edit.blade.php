@extends('layouts.pack.drivers')
@section('content1')
<div class="d-flex justify-content-center">
    <form  action="{{ route('driver.update',$driver->id) }}" enctype="multipart/form-data" method="post">
        @method("PUT")
        @csrf
    <div class="ui-container ui-11w">
        <h4 class="text-center font-weight-bold">Editing Driver</h4>
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
                <input type="text" class="form-control" id="name" name="name" placeholder="Fullname" value="{{ $driver->fullname }}">
              </div>
              <div class="form-group col-6 row">
                <label for="type" class="col-form-label col-3 font-weight-bold">Type</label>
                <select class="form-control font-weight-bold col-8" id="type" name="type" onchange="checkdrivertype()">
              
                  <option value="company" class="text-info font-weight-bold">Company Driver</option>
                  <option value="owner" class="text-success font-weight-bold">Owner Driver</option>
                  <option value="lease" class="text-warning font-weight-bold">Lease Driver</option>
                 
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
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="(123)-456-7890" value="{{ $driver->phone }}" oninput="formatnumber2()">
                      </div>
                    </div>
                   
                  </div>
                <div class="form-group col-6">
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="{{ $driver->email }}">
                </div>
              </div>
                  {{-- //second driver info --}}
                  <div class="secondD d-none">
                    <div class="row mt-3">
                      <div class="form-group col">
                        <input type="text" class="form-control" id="name1" name="name1" placeholder="Fullname of Second Driver">
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
                                <input type="text" class="form-control" id="phone1" name="phone1" placeholder="(123) 456-7890" oninput="formatnumber2()">
                              </div>
                            </div>
                           
                          </div>
                        <div class="form-group col-6">
                          <input type="text" class="form-control" id="email1" name="email1" placeholder="Email">
                        </div>
                      </div>
                    </div>
              <div class="row mt-3">
                <div class="form-group col-6">
                  <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="{{ $driver->address }}">
                </div>
                <div class="form-group col-6 row">
                    <label for="status" class="col-form-label col-3 font-weight-bold">Status</label>
                    <select class="form-control font-weight-bold col-8" id="status" name="status">
                      <option value="active" class="text-success font-weight-bold">Active</option>
                      <option value="rest" class="text-secondary font-weight-bold">Rest</option>
                      <option value="vacation" class="text-warning font-weight-bold">Vacation</option>
                      <option value="deleted" class="text-warning font-weight-bold">Not Working</option>
                    </select>
                  </div>
              </div>
              <div class="row mt-3">
                <div class="form-group col">
                  <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Comments here ..."> {{ $driver->comment }}</textarea>
                </div>
              </div>
              <div class="row d-flex flex-row-reverse justify-content-center">
                <button type="submit" class="btn btn-success mr-2 btn-block btn-lg mt-3 mb-3 w-50 font-weight-bold">Update</button>
              </div>
    </div>
    </form>
</div>

@endsection

@section('js1')
<script>
  function checkdrivertype(){
   if($('#type').val() =='team' ){
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
  phone=$('#phone').val();
  formatted=normalize(phone);
  if(formatted){
  $('#phone').val(formatted);
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
 $("#type").val("{{ $driver->type}}").change();
 $("#status").val("{{ $driver->status}}").change();
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