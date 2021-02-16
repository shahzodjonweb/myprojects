@extends('layouts.pack.driverreport')
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
      <button type="button" class="btn btn-primary" onclick="location.href='{{ url('load/create2') }}'"><i class="fas fa-plus"></i></button>
      <button type="button" class="btn btn-info "><i class="fas fa-file-excel"></i></button>
      <button type="button" class="btn btn-secondary"><i class="fas fa-chart-line"></i></button>
    </div>
  </div>
  </div>
  
  {{-- Main Part --}}
  
  <div class="ui-container row mt-2">
   
    @if ($drivers->count()>0 )
      <table class="table mt-2 table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Fullname</th>
            <th scope="col">Type</th>
            <th scope="col">Status</th>
            <th scope="col">Fuel</th>
            <th scope="col">Recurring payment</th>
            <th scope="col">Deduction payment</th>
            <th scope="col">Edit</th>
            <th scope="col">View</th>
          
  
          </tr>
        </thead>
        <tbody>
            @php
                $a=0;
            @endphp
          @foreach ($drivers as $driver)
            @php
                $a++;
            @endphp
          <tr>
             <th scope="row">{{ $a }}</th>
            <td onclick="location.href='{{ route('report.show',$driver->id) }}'">{{ $driver->fullname }}</td>
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
              <div style="color:rgb(0, 255, 136)">Team Driver</div>
          @endif
            </td>
            <td>
              @if ($driver->status == "active")
                  <div class="text-success">Active</div>
              @endif
              @if ($driver->status == "rest")
              <div class="text-secondary">Rest</div>
          @endif
              @if ($driver->status == "vacation")
              <div class="text-warning">Vacation</div>
          @endif
              @if ($driver->status == "inactive")
              <div class="text-danger">Not Working</div>
          @endif
                  
            </td>
            <td>0</td>
            <td>0</td>
            <td>0</td>
           
            {{-- <td>
              <div class="btn-group col-8" role="group" aria-label="Second group">
              <button type="button" class="btn btn-primary"><i class="fas fa-file"></i></button>
              <button type="button" class="btn btn-secondary "><i class="fas fa-file-alt"></i></button>
              <button type="button" class="btn btn-info"><i class="fas fa-file-invoice-dollar"></i></button>
            </div>
          </td> --}}
          <td>
            <div class="btn-group col-8" role="group" aria-label="Second group">
              <button type="button" class="btn btn-primary" onclick="location.href='{{ route('driver.edit',$driver->id) }}'"><i class="fas fa-edit"></i></button> 
            <button type="button" class="btn btn-danger " onclick="deleteDriver({{ $driver->id }})"><i class="fas fa-trash-alt"></i></button>
          </div>
        </td>
        <td>
          <div class="btn-group col-8" role="group" aria-label="Second group">
            <i class="fas fa-eye text-primary" onclick="location.href='{{ route('report.show',$driver->id) }}'"></i>
        </div>
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
 
</script>
<script>
  $('#tab-1').prop( "checked", true );
$('#tab-2').prop( "checked", false );
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection