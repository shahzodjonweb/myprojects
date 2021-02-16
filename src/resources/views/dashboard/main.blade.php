@extends('layouts.pack.dashboard')
@section('content1')

{{-- Search Bar --}}
<div class="ui-search-container row">
  <div class="col form-group">
    <input type="text" name="aa" id="aa" class="form-control form-control-sm ui-search-element">
  </div>
  <div class="col form-group">
    <input type="text" name="aa" id="aa" class="form-control form-control-sm ui-search-element">
  </div>
  <div class="col form-group">
    <input type="text" name="aa" id="aa" class="form-control form-control-sm ui-search-element">
  </div>
  <div class="col form-group">
    <input type="text" name="aa" id="aa" class="form-control form-control-sm ui-search-element">
  </div>
  
  <div class="col">
    <div class="btn-group col-3 " role="group" aria-label="Third group">
      <button type="button" class="btn btn-success"><i class="fas fa-search"></i></button>
    </div>
    <div class="btn-group col-8" role="group" aria-label="Second group">
      <button type="button" class="btn btn-primary" onclick="location.href='{{ route('load.create') }}'"><i class="fas fa-plus"></i></button>
      <button type="button" class="btn btn-info "><i class="fas fa-file-excel"></i></button>
      <button type="button" class="btn btn-secondary"><i class="fas fa-chart-line"></i></button>
    </div>
  </div>
  </div>
  
  {{-- Main Part --}}
  
  <div class="ui-container row mt-2">
    @if ($activeDrivers->count() != 0 || $restDrivers->count() != 0 )
      <table class="table mt-2 table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Fullname</th>
            <th scope="col">Type</th>
            <th scope="col">Phone</th>
            <th scope="col">Pickup</th>
            <th scope="col">Pickup date</th>
            <th scope="col">Delivery</th>
            <th scope="col">Delivery date</th>
            <th scope="col">Load Status</th>
            <th scope="col" colspan="2">Comment</th>
            <th scope="col">View</th>
          
  
          </tr>
        </thead>
        <tbody>
            @php
                $a=0;
            @endphp
          @foreach ($activeDrivers->merge($restDrivers) as $driver)

          @php
             $load=$driver->currentload();
            
          @endphp
                @php
                    $a++;
                @endphp
          <tr>
             <th scope="row">{{ $a }}</th>
            <td onclick="location.href='{{ route('driver.show',$driver->id) }}'">{{ $driver->fullname }}</td>
            <td>
              @if ($driver->type == "company")
                  <div class="text-success">Company Driver</div>
              @endif
              @if ($driver->type == "owner")
                  <div class="text-info">Owner Driver</div>
              @endif
              @if ($driver->type == "lease")
                  <div class="text-primary">Lease Driver</div>
              @endif
              @if ($driver->type == "team")
              <div style="color:rgb(14, 78, 48)">Team Driver</div>
          @endif
            </td>
            <td >{{ $driver->phone }}</td>
            {{-- load info --}}
            <td >
              @if (!empty($load))
              {{ $load->pickup()->getLocationFormat2() }}
              @else
                 <div class="text-warning">Waiting</div> 
              @endif
              </td>

              <td >
                @if (!empty($load))
                {{ $load->pickup()->time }}
                @else
                   <div class="text-warning">Waiting</div> 
                @endif
                </td>
                <td >
                  @if (!empty($load))
                  {{ $load->delivery()->getLocationFormat2() }}
                  @else
                     <div class="text-warning">Waiting</div> 
                  @endif
                  </td>
                  <td >
                    @if (!empty($load))
                    {{ $load->delivery()->time }}
                    @else
                       <div class="text-warning">Waiting</div> 
                    @endif
                    </td>
                    <td class="d-flex justify-content-center" >
                      @if (!empty($load))
                      <form class="changestatus{{ $load->id }}" action="{{ url('load/changestatus') }}" method="post">
                        @csrf
                        @if ($load->status == "active")

                         
                            <input type="hidden" name="load_id" value="{{ $load->id }}">
                              <select class="form-control font-weight-bold form-control-sm text-success"  name="status" onchange="changeStatus({{ $load->id }})">
                                <option value="inactive" class="text-warning ">Not Started</option>
                                <option value="active" class="text-success " selected>Started</option>
                                <option value="finished" class="text-info ">Finished</option>
                                <option value="canceled" class="text-danger ">Canceled</option>
                              </select>
                           
                        @endif
                        @if ($load->status == "inactive")
                             
                            <input type="hidden" name="load_id" value="{{ $load->id }}">
                              <select class="form-control font-weight-bold form-control-sm text-success"  name="status" onchange="changeStatus({{ $load->id }})">
                                <option value="inactive" class="text-warning " selected>Not Started</option>
                                <option value="active" class="text-success " >Started</option>
                                <option value="finished" class="text-info ">Finished</option>
                                <option value="canceled" class="text-danger ">Canceled</option>
                              </select>
                            
                        @endif
                      </form>
                      @else
                          <div class="text-warning">Waiting</div> 
                      @endif
                      </td>
         
            <td colspan="2" style="text-align:left;width:150px;" class="comment">
            
              
              <form class="comment-form{{ $driver->id }}" action="{{ url("driver/changecomment") }}" method="post">
                @csrf
                <div class="commentContent" >{{ $driver->comment }}</div>
              <input type="hidden" name="comment_id" class="comment_id" value="{{ $driver->id }}">
            <input class="form-control commentText d-none" style="height:30px;width:100%;" type="text" name="comment" value="{{ $driver->comment }}">
          </form>
        </td>
           
            {{-- <td>
              <div class="btn-group col-8" role="group" aria-label="Second group">
              <button type="button" class="btn btn-primary"><i class="fas fa-file"></i></button>
              <button type="button" class="btn btn-secondary "><i class="fas fa-file-alt"></i></button>
              <button type="button" class="btn btn-info"><i class="fas fa-file-invoice-dollar"></i></button>
            </div>
          </td> --}}
      
        <td >
            <i class="fas fa-eye text-primary "  onclick="location.href='{{ route('driver.show',$driver->id) }}'"></i>
        
      </td>
          </tr>
          @endforeach
       
        </tbody>
      </table>
    @endif
        

    
  </div>
@endsection

@section('js1')
<script>
  function changeStatus(id){
    $(".changestatus"+id).submit();
  }
 $( ".comment" ).dblclick(function() {
   id=$(this).children().children('.comment_id').val();
   $(this).children().children('.commentContent').addClass( "d-none");
  $(this).children().children('.commentText').removeClass( "d-none");

  $(this).children().children('.commentText').focusout(function() {
  $(".comment-form"+id).submit();
  })
});
</script>
<script>
  $('#tab-1').prop( "checked", true );
$('#tab-2').prop( "checked", false );
$('#tab-3').prop( "checked", false );
</script>
@endsection

@section('css1')
    <style>
    </style>
@endsection