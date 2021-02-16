@extends('layouts.pack.driverinfo')
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
      <button type="button" class="btn btn-primary"><i class="fas fa-plus"></i></button>
      <button type="button" class="btn btn-info "><i class="fas fa-file-excel"></i></button>
      <button type="button" class="btn btn-secondary"><i class="fas fa-chart-line"></i></button>
    </div>
  </div>
  </div>
  
  {{-- Main Part --}}
  
  <div class="ui-container row mt-2">
    <div class="alert alert-info row" style="width:100%" role="alert">
      <div class="col">Name: {{ $driver->fullname }}</div>
      <div class="col">Phone: {{ $driver->phone }}</div>
      <div class="col">Email: {{ $driver->email }}</div>
    </div>
    <table class="table mt-2 table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Load number</th>
          <th scope="col">Broker</th>
          <th scope="col">Pickup Location</th>
          <th scope="col">Pickup Date</th>
          <th scope="col">Delivery Location</th>
          <th scope="col">Delivery Date</th>
          <th scope="col">Rate</th>
          <th scope="col">Detention</th>
          <th scope="col">Lumper</th>
          <th scope="col">Tonu</th>
          <th scope="col">Status</th>
          <th scope="col">Comment</th>
          <th scope="col">Documents</th>
          <th scope="col">Edit</th>
          <th scope="col">Check</th>

        </tr>
      </thead>
      <tbody>
        @php
        $sum=0;
        $sum1=0;
        $sum2=0;
        $sum3=0;
        $a=0;
        foreach ($loads as $load) {
         $sum+=$load->price;
         $sum1+=$load->detention;
         $sum2+=$load->lumper;
         $sum3+=$load->tonu;
        }
        
        @endphp
        @foreach ($loads as $load)
        @php
            $a++;
        @endphp
        <tr>
          <th scope="row">{{ $a }}</th>
          <td>{{ $load->number }}</td>
          <td>{{ $load->broker->name }}</td>
          <td>{{ $load->pickup()->location->zipcode}} {{$load->pickup()->location->county}} {{ $load->pickup()->location->state}}</td>
          <td>{{ date('m/d/Y', strtotime($load->pickup()->time))}} </td>
          <td>{{ $load->delivery()->location->zipcode}} {{$load->delivery()->location->county}} {{ $load->delivery()->location->state}}</td>
          <td>{{ date('m/d/Y', strtotime($load->delivery()->time))}}</td>
          <td>${{ $load->price }}</td>
          <td>${{ $load->detention }}</td>
          <td>${{ $load->lumper }}</td>
          <td>${{ $load->tonu }}</td> 
          <td>{{ $load->status }}</td>
          <td>{{ $load->comment }}</td>
          <td>
            <div class="btn-group col-8" role="group" aria-label="Second group">
              <button type="button" class="btn btn-primary"
              @if (empty($load->rc))
              title="Not uploaded!"
             @else
             onclick="location.href='{{ asset('storage/'.$load->rc) }}'"
             @endif
              
              ><i class="fas fa-file"></i></button>
              <button type="button" class="btn btn-secondary " 
              @if (empty($load->bol))
               title="Not uploaded!"
              @else
              onclick="location.href='{{ asset('storage/'.$load->bol) }}'"
              @endif
              
              
              ><i class="fas fa-file-alt"></i></button>
              <button type="button" class="btn btn-info"
              @if (empty($load->invoice))
              title="Not uploaded!"
             @else
             onclick="location.href='{{ asset('storage/'.$load->invoice) }}'"
                          @endif
              ><i class="fas fa-file-invoice-dollar"
              
              ></i></button>
            </div>
        </td>
        <td>
          <div class="btn-group col-8" role="group" aria-label="Second group">
            <button type="button" class="btn btn-primary" onclick="location.href='{{ route('load.edit',$load->id) }}'"><i class="fas fa-edit"></i></button>         
            <button type="button" class="btn btn-danger "  onclick="deleteLoad({{ $load->id }})"><i class="fas fa-trash-alt"></i></button>
        </div>
      </td>
      <td>
        <div class="btn-group col-8" role="group" aria-label="Second group">
          <i class="fas fa-eye text-primary"></i>
      </div>
    </td>
        </tr>
        @endforeach
     <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
       <td class="font-weight-bold text-right">Sum:</td>
       <td class="font-weight-bold">${{ $sum }}</td>
       <td class="font-weight-bold">${{ $sum1 }}</td>
       <td class="font-weight-bold">${{ $sum2 }}</td>
       <td class="font-weight-bold">${{ $sum3 }}</td>
       <td></td>
       <td></td>
     </tr>
        
      </tbody>
    </table>
    
    <div class="ml-5">{{ $loads->links() }}</div>
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