@extends('layouts.pack.brokers')
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
      <button type="button" class="btn btn-primary" onclick="location.href='{{ route('broker.create') }}'"><i class="fas fa-plus"></i></button>
      <button type="button" class="btn btn-info "><i class="fas fa-file-excel"></i></button>
      <button type="button" class="btn btn-secondary"><i class="fas fa-chart-line"></i></button>
    </div>
  </div>
  </div>
  
  {{-- Main Part --}}
  
  <div class="ui-container row mt-2">
    
      <table class="table mt-2 table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Company name</th>
            <th scope="col">Address</th>
            <th scope="col">Phone</th>
            <th scope="col">Email</th>
            <th scope="col">Fax</th>
            <th scope="col">MC#</th>
            <th scope="col">DOT#</th>
            <th scope="col">Edit</th>
            <th scope="col">View</th>
          
  
          </tr>
        </thead>
        <tbody>
            @php
                $a=0;
            @endphp
          @foreach ($brokers as $broker)
            @php
                $a++;
            @endphp
          <tr>
             <th scope="row">{{ $a }}</th>
            <td>{{ $broker->name }}</td>
            <td>
                {{ $broker->address }}
            </td>
            <td>{{ $broker->phone }} </td>
            <td>{{ $broker->email }}</td>
            <td>{{ $broker->fax }}</td>
            <td>
                {{ $broker->mc }}
            </td>
            <td>{{ $broker->dot }}</td>
           
            {{-- <td>
              <div class="btn-group col-8" role="group" aria-label="Second group">
              <button type="button" class="btn btn-primary"><i class="fas fa-file"></i></button>
              <button type="button" class="btn btn-secondary "><i class="fas fa-file-alt"></i></button>
              <button type="button" class="btn btn-info"><i class="fas fa-file-invoice-dollar"></i></button>
            </div>
          </td> --}}
          <td>
            <div class="btn-group col-8" role="group" aria-label="Second group">
              <button type="button" class="btn btn-primary" ><i class="fas fa-edit"></i></button> 
            <button type="button" class="btn btn-danger "><i class="fas fa-trash-alt"></i></button>
          </div>
        </td>
        <td>
          <div class="btn-group col-8" role="group" aria-label="Second group">
            <i class="fas fa-eye text-primary" ></i>
        </div>
      </td>
          </tr>
          @endforeach
       
          
        </tbody>
   
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