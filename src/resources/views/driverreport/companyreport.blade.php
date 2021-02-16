@extends('layouts.pack.driverreport')
@section('content1')
{{-- Search Bar --}}
@php
          $profit1=0;
          $profit2=0;
@endphp
<div class="ui-search-container row">
  <div class="d-flex justify-content-center col-6">
    <label for="deliveryDate" class="col-form-label col-3 font-weight-bold">See previous records:</label>

      <ul class="pagination col-9">
        <li class="page-item back backward">
          <a class="page-link bg-success " ><i class="fas fa-backward text-white"></i></a>
        </li>
        <li class="page-item disabled d-none"><a class="page-link" href="#">...</a></li>
        @for ($i = 1; $i <= $caches; $i++)
       
        <li class="page-item 
        @if ($i==$selected)
            active
        @endif
        s_item"><a class="page-link" href="#">{{ $i }}</a></li>
        @endfor
        {{-- <li class="page-item s_item"><a class="page-link" href="#">10</a></li>
        <li class="page-item s_item"><a class="page-link" href="#">9</a></li>
        <li class="page-item s_item"><a class="page-link" href="#">8</a></li>
        <li class="page-item s_item"><a class="page-link" href="#">7</a></li>
        <li class="page-item s_item"><a class="page-link" href="#">6</a></li>
        <li class="page-item s_item"><a class="page-link" href="#">5</a></li>
        <li class="page-item s_item"><a class="page-link" href="#">4</a></li>
        <li class="page-item s_item"><a class="page-link" href="#">3</a></li>
        <li class="page-item s_item"><a class="page-link" href="#">2</a></li> --}}
        
        <li class="page-item disabled d-none"><a class="page-link" href="#">...</a></li>
        <li class="page-item next forward" >
          <a class="page-link bg-success " ><i class="fas fa-forward text-white"></i></a>
        </li>
      </ul>
      <form action="{{ url('report/showcompany2' ) }}" method="post" class="selection_form">
        @csrf
        <input type="hidden" name="selection"  id="selection" value="{{ $selected }}">
      </form>
    </div>
   
  <div class="form-group row col-4">
    
    <label for="dateselect" class="col-form-label col-3 font-weight-bold">Select Date:</label>
    <div class="col-9">
      <form action="{{ url('report/sortByDate') }}" method="post" id="selecteddate">
        @csrf
      <input type="datetime-local" class="form-control " id="dateselect" name="dateselect" onchange="getElementById('selecteddate').submit()">
    </form>
    </div>
  
  </div>
 
  
  <div class="col-2">
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
            <th scope="col">Driver Profit</th>
            <th scope="col">Company Profit</th>
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
            <td class="font-weight-bold">{{ $driver->getWeeklyRevenueDriver($selected,$driver->type) }}</td>
           <td class="font-weight-bold">{{ $driver->getWeeklyRevenueCompany($selected,$driver->type) }}</td>
           
            {{-- <td>
              <div class="btn-group col-8" role="group" aria-label="Second group">
              <button type="button" class="btn btn-primary"><i class="fas fa-file"></i></button>
              <button type="button" class="btn btn-secondary "><i class="fas fa-file-alt"></i></button>
              <button type="button" class="btn btn-info"><i class="fas fa-file-invoice-dollar"></i></button>
            </div>
          </td> --}}
        
        <td>
          <div class="btn-group col-8" role="group" aria-label="Second group">
            <i class="fas fa-eye text-primary" onclick="location.href='{{ route('report.show',$driver->id) }}'"></i>
        </div>
      </td>
          </tr>
        
          @endforeach
          @php
        
                                   foreach ($drivers as $driver) {
                                       $profit1+=$driver->getWeeklyRevenueCompany($selected,$driver->type);
                                       $profit2+=$driver->getWeeklyRevenueDriver($selected,$driver->type);
                                   }
   
        
                                
     @endphp
            <tr>
              <th scope="row"></th>
              <td colspan="4" class="text-right font-weight-bold">Total:</td>
              <td class="font-weight-bold">{{  $profit2 }}</td>
              <td class="font-weight-bold">{{ $profit1 }}</td>
              <td></td>
            </tr>
        </tbody>
      </table>
    @endif
    
  </div>
      
  
  <div class="ui-container row mt-2">
 
<div class="alert alert-info row" style="width:100%" role="alert">
  <div class="col text-left font-weight-bold mx-5" style="font-size: 25px;">Total Company profit: ${{ $profit1 }}</div>
  <div class="col text-right font-weight-bold mx-5" style="font-size: 25px;">Total Driver profit: ${{ $profit2 }}</div>
</div>


  </div>
@endsection

@section('js1')
<script>
  $( ".s_item" ).on( "click", function() {
    $('#selection').val($(this).children().text());
    $('.selection_form').submit();
});

$( ".forward" ).on( "click", function() {
  val=parseInt($('#selection').val())+1;
  if(val <= {{ $caches }}){
    $('#selection').val(parseInt($('#selection').val())+1);
    $('.selection_form').submit();
  }
    
});

$( ".backward" ).on( "click", function() {
  val=parseInt($('#selection').val())-1;
  if(val >= 1 ){
    $('#selection').val(parseInt($('#selection').val())-1);
    $('.selection_form').submit();
  }
    
});
</script>
<script>
 function addfuel(){
    $('#addexpence').removeClass('d-none');
    
    $('.fuelform').removeClass('d-none');
    $('.recurringform').addClass('d-none');
    $('.deductionform').addClass('d-none');

    $('.modalexpence').text('Add Fuel');
    
 }
 function addrecurring(){
    $('#addexpence').removeClass('d-none');
    
    $('.fuelform').addClass('d-none');
    $('.recurringform').removeClass('d-none');
    $('.deductionform').addClass('d-none');

    $('.modalexpence').text('Add Recurring');
 }
 function adddeduction(){
     $('#addexpence').removeClass('d-none');
   
     $('.fuelform').addClass('d-none');
    $('.recurringform').addClass('d-none');
    $('.deductionform').removeClass('d-none');

    $('.modalexpence').text('Add Deduction');
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