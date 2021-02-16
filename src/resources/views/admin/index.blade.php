@extends('layouts.pack.admin')
@section('content1')

<div class="d-flex justify-content-center">
    <form  action="{{ route('admin.update',$admin->id) }}" enctype="multipart/form-data" method="post">
        @csrf 
        @method('PUT')
    <div class="ui-container ui-12w">
        <h4 class="text-center font-weight-bold">Company Info</h4>
        <hr>
             
        <div class="row mt-3">
          <div class="form-group col">
            <input type="text" class="form-control" id="name" name="name" placeholder="Company name" value="{{ $admin->name }}">
          </div>
        
          <div class="form-group col">
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ isset($admin) ? $admin->email : '' }}"> 
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
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $admin->phone }}" placeholder="(123) 456-7890" oninput="formatnumber()">
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
                        <input type="text" class="form-control" id="fax" name="fax" value="{{ $admin->fax }}" placeholder="(123) 456-7890" oninput="formatnumber2()">
                      </div>
                    </div>
                  </div>
              </div>
            
            <div class="row mt-3">
             
              <div class="form-group col-6">
                <input type="text" name="address" id="address" placeholder="Address" class="form-control" value="{{ $admin->location }}">
              </div>
              <div class="form-group col-6">
                <input type="text" class="form-control" id="bank" name="bank" placeholder="Bank name" value="{{ $admin->bank }}">
              </div>
            </div>

            <div class="row mt-3">
             
              <div class="form-group col-6">
                <input type="text" name="accounting" id="accounting" placeholder="Accounting Number #" class="form-control" value="{{ $admin->accounting }}">
              </div>
              <div class="form-group col-6">
                <input type="text" class="form-control" id="routing" name="routing" placeholder="Routing Number #" value="{{ $admin->routing }}">
              </div>
            </div>
           

            <div class="row mt-3">
              <div class="row col-6">
                  <label for="phone" class="col-form-label col-3 font-weight-bold">MC#</label>
                  <div class="col-9 form-group">
                    <input type="text" class="form-control" id="mc" name="mc" value="{{ $admin->mc }}" >
                  </div>
                </div>
                <div class="row col-6">
                  <label for="dot" class="col-form-label col-3 font-weight-bold">DOT#</label>
                  <div class="col-9 form-group">
                    <input type="text" class="form-control" id="dot" name="dot" value="{{ $admin->dot }}" >
                  </div>
                </div>
            </div>
            <div class="row mt-3">
              <label for="phone" class="col-form-label col-3 font-weight-bold">Invoicenumber</label>
              <div class="col-7">
                <div class="input-group">
                  
                  <input type="number" class="form-control" id="invoicenumber" name="invoicenumber" value="{{ $admin->invoicenumber }}" placeholder="(123) 456-7890" oninput="formatnumber2()">
                </div>
              </div>
            </div>

          

            <div class="container">
             
              <div class="avatar-upload">
                  <div class="avatar-edit">
                      <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                      <label for="imageUpload"></label>
                  </div>
                  <div class="avatar-preview">
                      <div id="imagePreview">
                      </div>
                  </div>
              </div>
              <input type="hidden" name="imageUploadbase64" id="imageUploadbase64">
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

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
function encodeImageFileAsURL(element) {
  var file = element.files[0];
  var reader = new FileReader();
  reader.onloadend = function() {
    $("#imageUploadbase64").val(reader.result);
  }
  reader.readAsDataURL(file);
}
$("#imageUpload").change(function() {
    readURL(this);
    encodeImageFileAsURL(this);
});


</script>

<script>
  function formatnumber(){
  phone=$('#phone').val();
  formatted=normalize(phone);
  if(formatted){
  $('#phone').val(formatted);
}
}

function formatnumber2(){
  phone=$('#fax').val();
  formatted=normalize(phone);
  if(formatted){
  $('#fax').val(formatted);
}
}

  $('#tab-1').prop( "checked", true );
$('#tab-2').prop( "checked", false );
</script>
@endsection

@section('css1')
    <style>
      #imagePreview{
        background-image: url("{{ $admin->logo }}");
      }
      
   .avatar-upload {
    position: relative;
    max-width: 205px;
    margin: 50px auto;
    
  
}
.avatar-upload .avatar-edit {
        position: absolute;
        right: 12px;
        z-index: 1;
        top: 10px;
        
    }
    .avatar-upload .avatar-edit input {
            display: none;
           
        }
        .avatar-upload .avatar-edit input   + label {
                display: inline-block;
                width: 34px;
                height: 34px;
                margin-bottom: 0;
                border-radius: 100%;
                background: #FFFFFF;
                border: 1px solid transparent;
                box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
                cursor: pointer;
                font-weight: normal;
                transition: all .2s ease-in-out;
              
            }
            .avatar-upload .avatar-edit input   + label  :hover {
                    background: #f1f1f1;
                    border-color: #d6d6d6;
                }
                .avatar-upload .avatar-edit input   + label    :after {
                    content: "\f040";
                    font-family: 'FontAwesome';
                    color: #757575;
                    position: absolute;
                    top: 10px;
                    left: 0;
                    right: 0;
                    text-align: center;
                    margin: auto;
                }
    .avatar-upload .avatar-preview {
        width: 192px;
        height: 192px;
        position: relative;
        border-radius: 100%;
        border: 6px solid #F8F8F8;
        box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
       
    }
    .avatar-upload .avatar-preview > div {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
@endsection
