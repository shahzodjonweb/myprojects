@extends('layouts.pack.admin')
@section('content1')

<div class="d-flex justify-content-center">
    <form  action="{{ route('admin.update',$admin->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('PUT')
    <div class="ui-container container mx-5">
        <h4 class="text-center font-weight-bold">Company Info</h4>
        <hr>
             
      
            <div class="row mt-3">
              <label for="phone" class="col-form-label col-4 font-weight-bold">Payment Weekday</label>
              <div class="col-7">
                <div id="weekdays" onclick="getindex()"> </div>
                <input type="hidden" name="weekindex" id="weekindex">
              </div>
            </div>
                <div class="row mt-3">
                    <label for="phone" class="col-form-label col-6 font-weight-bold">Dispatch Fee </label>
                    <div class="col-6">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text">%</span>
                        </div>
                        <input type="number" step=0.01 min="0" class="form-control" id="dispatch_fee" name="dispatch_fee" value="{{ $admin->dispatch_fee }}"  oninput="formatnumber()">
                      </div>
                    </div>
                   
                  </div>
                  <div class="row mt-3">
                    <label for="phone" class="col-form-label col-6 font-weight-bold">Permile (for company drivers)</label>
                    <div class="col-6">
                      <div class="input-group">
                        <div class="input-group-prepend ">
                          <span class="input-group-text">$</span>
                        </div>
                        <input type="number" step=0.01 min="0" class="form-control" id="permile" name="permile" value="{{ $admin->permile }}" oninput="formatnumber2()">
                      </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <label for="phone" class="col-form-label col-6 font-weight-bold">Insurance</label>
                    <div class="col-6">
                        <div class="input-group">
                            <div class="input-group-prepend ">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step=0.01 min="0" class="form-control" id="insurance" name="insurance" value="{{ $admin->insurance }}" oninput="formatnumber2()">
                          </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <label for="phone" class="col-form-label col-6 font-weight-bold">ELD</label>
                    <div class="col-6">
                        <div class="input-group">
                            <div class="input-group-prepend ">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step=0.01 min="0" class="form-control" id="eld" name="eld" value="{{ $admin->eld }}" oninput="formatnumber2()">
                          </div>
                    </div>
                  </div>
                  <div class="row mt-3">
                    <label for="phone" class="col-form-label col-6 font-weight-bold">IFTA</label>
                    <div class="col-6">
                        <div class="input-group">
                            <div class="input-group-prepend ">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step=0.01 min="0" class="form-control" id="ifta" name="ifta" value="{{ $admin->ifta }}" oninput="formatnumber2()">
                          </div>
                    </div>
                  </div>
              
                  <div class="row mt-3">
                    <label for="phone" class="col-form-label col-6 font-weight-bold">Lease Truck</label>
                    <div class="col-6">
                        <div class="input-group">
                            <div class="input-group-prepend ">
                              <span class="input-group-text">$</span>
                            </div>
                            <input type="number" step=0.01 min="0" class="form-control" id="lease" name="lease" value="{{ $admin->lease }}" oninput="formatnumber2()">
                          </div>
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

$(function(){
  $('#weekdays').weekdays({
    singleSelect:true,
    selectedIndexes: [{{ $admin->weekindex }}]

  });
  getindex();
});
function getindex(){
index=$('#weekdays').selectedIndexes();
$('#weekindex').val(index[0]);
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
