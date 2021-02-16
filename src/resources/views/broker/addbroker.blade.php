@extends('layouts.pack.brokers')
@section('content1')

<div class="d-flex justify-content-center">
    <form  action="{{ route('broker.store') }}" enctype="multipart/form-data" method="post">
        @csrf
    <div class="ui-container ui-12w">
        <h4 class="text-center font-weight-bold">Add Broker</h4>
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
            <input type="text" class="form-control" id="name" name="name" placeholder="Company name">
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
                  <div class="row col-6">
                    <label for="phone" class="col-form-label col-3 font-weight-bold">Fax</label>
                    <div class="col-9">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text">+1</span>
                        </div>
                        <input type="text" class="form-control" id="fax" name="fax" placeholder="(123) 456-7890" oninput="formatnumber2()" value="{{ old('fax') }}">
                      </div>
                    </div>
                   
                  </div>
              </div>
            
            <div class="row mt-3">
              <div class="form-group col-6">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
              </div>
              <div class="form-group col-6 row">
                <input type="text" name="address" id="address" placeholder="Address" class="form-control" value="{{ old('address') }}">
              </div>
            </div>

            <div class="row mt-3">
              <div class="row col-6">
                  <label for="phone" class="col-form-label col-3 font-weight-bold">MC#</label>
                  <div class="col-9 form-group">
                    <input type="text" class="form-control" id="mc" name="mc"  value="{{ old('mc') }}">
                  </div>
                </div>
                <div class="row col-6">
                  <label for="dot" class="col-form-label col-3 font-weight-bold">DOT#</label>
                  <div class="col-9 form-group">
                    <input type="text" class="form-control" id="dot" name="dot" value="{{ old('dot') }}">
                  </div>
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
  fax=$('#fax').val();
  formatted=normalize(fax);
  if(formatted){
  $('#fax').val(formatted);
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
