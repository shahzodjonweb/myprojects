@extends('layouts.pack.dashboard')
@section('content1')
{{-- Search Bar --}}
<form action="{{ url('load/searchload/live') }}" method="post">
  @csrf
<div class="ui-search-container row">
  <div class="col-4 form-group row">
    <label for="date1" class="col-form-label col-3 font-weight-bold ">Search by date:</label>
    <input type="date" name="date1" id="date1" class="form-control form-control-sm ui-search-element col-4"
    @if (!empty($search['date1']))
        value="{{ $search['date1'] }}"
    @endif
    >
    <div class="font-weight-bold mx-1">-</div>
    <input type="date" name="date2" id="date2" class="form-control form-control-sm ui-search-element col-4"
    @if (!empty($search['date2']))
        value="{{ $search['date2'] }}"
    @endif
    >
  </div>
  
  <div class="col-4 form-group row">
    <label for="date1" class="col-form-label col-2 font-weight-bold ">Rate:</label>
    <input type="number" name="rate1" id="rate1" placeholder="from" class="form-control form-control-sm ui-search-element col-4"
    @if (!empty($search['rate1']))
        value="{{ $search['rate1'] }}"
    @endif
    >
    <div class="font-weight-bold mx-1">-</div>
    <input type="number" name="rate2" id="rate2" placeholder="to" class="form-control form-control-sm ui-search-element col-5"
    @if (!empty($search['rate2']))
        value="{{ $search['rate2'] }}"
    @endif
    >
  </div>
  <div class="col form-group row">
    <label for="status" class="col-form-label col-3 font-weight-bold">Status:</label>
          <select class="form-control form-control-sm ui-search-element font-weight-bold col-8" id="status" name="status">
            <option value="0" class="text-warning font-weight-bold">Select</option>
            <option value="inactive" class="text-warning font-weight-bold">Not Started</option>
            <option value="active" class="text-success font-weight-bold">Started</option>
          </select>
  </div>
  <input type="hidden" name="page" value="dashboard.loadlist">
  <div class="col">
    <div class="btn-group col-3 " role="group" aria-label="Third group">
      <button type="submit" class="btn btn-success"><i class="fas fa-search"></i></button>
    </div>
    <div class="btn-group col-8" role="group" aria-label="Second group">
      <button type="button" class="btn btn-primary" onclick="location.href='{{ url('load/create2') }}'"><i class="fas fa-plus"></i></button>
      <button type="button" class="btn btn-info "><i class="fas fa-file-excel"></i></button>
      <button type="button" class="btn btn-secondary"><i class="fas fa-chart-line"></i></button>
    </div>
  </div>
  </div>
</form>
  
  {{-- Main Part --}}
  
  <div class="ui-container row mt-2">
    <table class="table mt-2 table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Load number</th>
          <th scope="col">Driver</th>
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
                $a=0;
            @endphp
        @foreach ($loads as $load)
        <tr>
                @php
              $a++;
          @endphp
          <th scope="row">{{ $a }}</th>
          <td>{{ $load->number }}</td>
          <td onclick="location.href='{{ route('driver.show',$load->driver->id) }}'">{{ $load->driver->fullname }}</td>
          <td >{{ $load->broker->name }}</td>
          <td>{{ $load->pickup()->location->zipcode}} {{$load->pickup()->location->county}} {{ $load->pickup()->location->state}}</td>
          <td>{{ $load->pickup()->time}} </td>
          <td>{{ $load->delivery()->location->zipcode}} {{$load->delivery()->location->county}} {{ $load->delivery()->location->state}}</td>
          <td>{{ $load->delivery()->time }}</td>
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
          <button type="button" class="btn btn-danger " onclick="deleteLoad({{ $load->id }})"><i class="fas fa-trash-alt"></i></button>
        </div>
      </td>
      <td>
        <div class="btn-group col-8" role="group" aria-label="Second group">
          <i class="fas fa-eye text-primary"></i>
      </div>
    </td>
        </tr>
        @endforeach
     
        
      </tbody>
    </table>
    
    <div class="ml-5">{{ $loads->links() }}</div>
  </div>
@endsection

@section('js1')
<script>
 
</script>
<script>
  $('#tab-1').prop( "checked", false );
$('#tab-2').prop( "checked", false );
$('#tab-3').prop( "checked", true );

@if (!empty($search['status']))
$("#status").val('{{ $search['status'] }}').change();
    @endif
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection