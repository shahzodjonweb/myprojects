@extends('layouts.pack.drivers')
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
      <button type="button" class="btn btn-primary" onclick="location.href='{{ route('driver.create') }}'"><i class="fas fa-plus"></i></button>
      <button type="button" class="btn btn-info "><i class="fas fa-file-excel"></i></button>
      <button type="button" class="btn btn-secondary"><i class="fas fa-chart-line"></i></button>
    </div>
  </div>
  </div>
  
  {{-- Main Part --}}
  
  <div class="ui-container row mt-2">
    @if ($activeDrivers->count() != 0 || $restDrivers->count() != 0  )
      <table class="table mt-2 table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Fullname</th>
            <th scope="col">Type</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Address</th>
            <th scope="col">Status</th>
            <th scope="col">Comment</th>
            <th scope="col">Edit</th>
            <th scope="col">View</th>
          
  
          </tr>
        </thead>
        <tbody>
            @php
                $a=0;
            @endphp
          @foreach ($activeDrivers->merge($restDrivers) as $driver)
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
              <div style="color:rgb(0, 255, 136)">Team Driver</div>
          @endif
            </td>
            <td>{{ $driver->phone }} </td>
            <td>{{ $driver->email }}</td>
            <td>{{ $driver->address }}</td>
            <td>
              <form class="changestatus{{ $driver->id }}" action="{{ url('driver/changestatus') }}" method="post">
                @csrf
                @if ($driver->status == "active")

                 
                    <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                      <select class="form-control font-weight-bold form-control-sm text-success"  name="status" onchange="changeStatus({{ $driver->id }})">
                        <option value="active" class="text-success font-weight-bold" selected>Active</option>
                        <option value="rest" class="text-secondary font-weight-bold">Rest</option>
                        <option value="vacation" class="text-warning font-weight-bold">Vacation</option>
                        <option value="deleted" class="text-warning font-weight-bold">Not Working</option>
                      </select>
                   
                @endif
                @if ($driver->status == "rest")
                     
                    <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                      <select class="form-control font-weight-bold form-control-sm text-success"  name="status" onchange="changeStatus({{ $driver->id }})">
                        <option value="active" class="text-success font-weight-bold">Active</option>
                        <option value="rest" class="text-secondary font-weight-bold" selected>Rest</option>
                        <option value="vacation" class="text-warning font-weight-bold">Vacation</option>
                        <option value="deleted" class="text-warning font-weight-bold">Not Working</option>
                      </select>
                    
                @endif
              </form>
             
            </td>
            <td>{{ $driver->comment }}</td>
           
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
            <i class="fas fa-eye text-primary" onclick="location.href='{{ route('driver.show',$driver->id) }}'"></i>
        </div>
      </td>
          </tr>
          @endforeach
       
          
        </tbody>
      
    @endif
        
    @if ($vacationDrivers->count() != 0 )
    
        <thead class="thead-dark mt-2 ">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Fullname</th>
            <th scope="col">Type</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Address</th>
            <th scope="col">Status</th>
            <th scope="col">Comment</th>
            <th scope="col">Edit</th>
            <th scope="col">View</th>
          
  
          </tr>
        </thead>
        <tbody>
                  @php
                    $b=0;
                  @endphp
          @foreach ($vacationDrivers as $driver)
          <tr>
                @php
                    $b++;
                @endphp
            <th scope="row">{{ $b }}</th>
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
              <div style="color:rgb(0, 255, 136)">Team Driver</div>
          @endif
            </td>
            <td>{{ $driver->phone }}</td>
            <td>{{ $driver->email }}</td>
            <td>{{ $driver->address }}</td>
            <td>
              <form class="changestatus{{ $driver->id }}" action="{{ url('driver/changestatus') }}" method="post">
                @csrf
           
                @if ($driver->status == "vacation")
                     
                    <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                      <select class="form-control font-weight-bold form-control-sm text-success"  name="status" onchange="changeStatus({{ $driver->id }})">
                        <option value="active" class="text-success font-weight-bold">Active</option>
                        <option value="rest" class="text-secondary font-weight-bold">Rest</option>
                        <option value="vacation" class="text-warning font-weight-bold" selected>Vacation</option>
                        <option value="deleted" class="text-warning font-weight-bold">Not Working</option>
                      </select>
                    
                @endif
              </form>
          
            </td>
            <td>{{ $driver->comment }}</td>
           
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
            <i class="fas fa-eye text-primary" onclick="location.href='{{ route('driver.show',$driver->id) }}'"></i>
        </div>
      </td>
          </tr>
          @endforeach
       
          
        </tbody>
      
    @endif

    @if ($inactiveDrivers->count() != 0 )
        <thead class="thead-dark mt-2">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Fullname</th>
            <th scope="col">Type</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Address</th>
            <th scope="col">Status</th>
            <th scope="col">Comment</th>
            <th scope="col">Edit</th>
            <th scope="col">View</th>
          
  
          </tr>
        </thead>
        <tbody>
              @php
                   $b=0;
              @endphp
          @foreach ($inactiveDrivers as $driver)
      <tr>
              @php
                  $b++;
              @endphp
        <th scope="row">{{ $b }}</th>
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
              <div style="color:rgb(0, 255, 136)">Team Driver</div>
          @endif
            </td>
            <td>{{ $driver->phone }}</td>
            <td>{{ $driver->email }}</td>
            <td>{{ $driver->address }}</td>
            <td>
              <form class="changestatus{{ $driver->id }}" action="{{ url('driver/changestatus') }}" method="post">
                @csrf
           
                     
                    <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                      <select class="form-control font-weight-bold form-control-sm text-success"  name="status" onchange="changeStatus({{ $driver->id }})">
                        <option value="active" class="text-success font-weight-bold">Active</option>
                        <option value="rest" class="text-secondary font-weight-bold" >Rest</option>
                        <option value="vacation" class="text-warning font-weight-bold" >Vacation</option>
                        <option value="deleted" class="text-warning font-weight-bold" selected>Not Working</option>
                      </select>
                    
              </form>
              
            </td>
            <td>{{ $driver->comment }}</td>
           
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
            <i class="fas fa-eye text-primary" onclick="location.href='{{ route('driver.show',$driver->id) }}'"></i>
        </div>
      </td>
          </tr>
          @endforeach
       
          
        </tbody>
     
    
    @endif

  </table>
    
    
  </div>
@endsection

@section('js1')
<script>
function changeStatus(id){
    $(".changestatus"+id).submit();
  }
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