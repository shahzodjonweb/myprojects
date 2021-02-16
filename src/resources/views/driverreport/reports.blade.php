@extends('layouts.pack.driverinfo')
@section('content1')
{{-- Search Bar --}}
<div class="ui-search-container row">
  <div class="d-flex justify-content-center col-6">
    <label for="deliveryDate" class="col-form-label col-3 font-weight-bold">See previous records:</label>

      <ul class="pagination col-9">
        <li class="page-item back backward">
          <a class="page-link bg-success " href="#"><i class="fas fa-backward text-white"></i></a>
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
        <li class="page-item next forward">
          <a class="page-link bg-success " href="#"><i class="fas fa-forward text-white"></i></a>
        </li>
      </ul>
      <form action="{{ url('report/showselection/'. $driver->id ) }}" method="post" class="selection_form">
        @csrf
        <input type="hidden" name="selection"  id="selection" value="{{ $selected }}">
      </form>
    </div>

  <div class="form-group row col-4">
    <label for="deliveryDate" class="col-form-label col-3 font-weight-bold">Select Date:</label>
    <div class="col-9">
      <form action="{{ url('report/sortByDateDrivers/'.$driver->id) }}" method="post" id="selecteddate">
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
   
    <div class="alert alert-info row" style="width:100%" role="alert">
        <div class="col">Name: {{ $driver->fullname }}</div>
        <div class="col">Phone: {{ $driver->phone }}</div>
        <div class="col">Email: {{ $driver->email }}</div>
      </div>
       
   
     
      {{-- <<<<<<<<<<<<<<<======================  Company Drivers #company ===========================>>>>>>>>>>>>>>>>>>>>>>>> --}}
      @if ($driver->type=="company")
      <div class="container w-100">
            <div class="row my-4">
                {{-- Loads Count --}}
                <div class="col-6 "> 
                  <h3>Load Payment</h3>
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Date</th>
                          <th scope="col">Load number</th>
                          <th scope="col">Rate</th>
                          <th scope="col">Milage</th>
                          <th scope="col">Deadhead</th>
                          <th scope="col">Total milage</th>
                          <th scope="col">Total(${{ $admin->permile }}/mile)</th>
                          
                        </tr>
                       
                      </thead>
                      <tbody>
                        @php
                          $b=0;
                        @endphp
                      @foreach ($loads as $load)
                       @php
                          $b++;
                      @endphp
                      <tr>
                        <th scope="row">{{ $b }}</th>
                        <td>{{ $load->created_at }}</td>
                        <td>{{ $load->number }}</td>
                        <td class="font-weight-bold">{{ $load->price}}</td>
                        <td class="font-weight-bold">{{ $load->milage}}</td>
                        <td class="font-weight-bold">{{ $load->deadhead}}-{{ $load->deadhead_d}}</td>
                        <td class="font-weight-bold">{{$load->milage+$load->deadhead - $load->deadhead_d}}</td>
                        <td class="font-weight-bold">{{($load->milage+$load->deadhead - $load->deadhead_d)*$admin->permile}}</td>
                      
                        
                       
                      </tr>
                      @endforeach
                        
                        <tr>
                          <th scope="row"></th>
                          <td colspan="2" class="text-right font-weight-bold">Total:</td>
                          <td class="font-weight-bold">{{ $loads->sum('price') }}</td>
                          <td class="font-weight-bold">{{ $loads->sum('milage') }}</td>
                          <td class="font-weight-bold">{{ $loads->sum('deadhead')-$loads->sum('deadhead_d') }}</td>
                          <td class="font-weight-bold">{{ $loads->sum('milage')+$loads->sum('deadhead')-$loads->sum('deadhead_d') }}</td>
                          <td class="font-weight-bold">{{ ($loads->sum('milage')+$loads->sum('deadhead')-$loads->sum('deadhead_d'))*$admin->permile }}</td>
                         
                        </tr>
                      </tbody>
                    </table>
                </div>
                {{-- Fuel --}}
                <div class="col-6 ">
                  <h3>Fuel Payment</h3>
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">State</th>
                          <th scope="col">Date</th>
                          <th scope="col">Price</th>
                          <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="addfuel()"><i class="fas fa-plus"></i></button></th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                        $b=0;
                      @endphp
                    @foreach ($fuels as $fuel)
                     @php
                        $b++;
                    @endphp
                    <tr>
                      <th scope="row">{{ $b }}</th>
                      <td>{{ $fuel->state }}</td>
                      <td>{{ $fuel->date }}</td>
                      <td class="font-weight-bold">{{ $fuel->price }}</td>
                     <td></td>
                    </tr>
                    @endforeach
                    <tr>
                      <th scope="row"></th>
                      <td colspan="2" class="text-right font-weight-bold">Total:</td>
                      <td class="font-weight-bold">{{ $fuels->sum('price') }}</td>
                      <td></td>
                    </tr>
                      </tbody>
                    </table>
                </div>
            </div>
      
            <div class="row my-4">
                {{-- Recurring Payment --}}
              <div class="col-6 ">
                <h3>Recurring Payment</h3>
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="addrecurring()"><i class="fas fa-plus"></i></button></th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                        $b=0;
                      @endphp
                    @foreach ($recurrings as $recurring)
                     @php
                        $b++;
                    @endphp
                    <tr>
                      <th scope="row">{{ $b }}</th>
                      <td>{{ $recurring->name }}</td>
                      <td class="font-weight-bold">{{ $recurring->price }}</td>
                      <td></td>
                    </tr>
                    @endforeach
                    <tr>
                      <th scope="row"></th>
                      <td class="text-right font-weight-bold">Total:</td>
                      <td class="font-weight-bold">{{ $recurrings->sum('price') }}</td>
                      <td></td>
                    </tr>
                      </tbody>
                    </table>
              </div>
              {{-- Decuction Payment --}}
              <div class="col-6 ">
                <h3>Deduction Payment</h3>
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="adddeduction()"><i class="fas fa-plus"></i></button></th>
                        </tr>
                      </thead>
                      <tbody>
                       
                        @php
                        $b=0;
                      @endphp
                    @foreach ($deductions as $deduction)
                     @php
                        $b++;
                    @endphp
                    <tr>
                      <th scope="row">{{ $b }}</th>
                      <td>{{ $deduction->name }}</td>
                      <td class="font-weight-bold">{{ $deduction->price }}</td>
                       <td></td>
                    </tr>
                    @endforeach
                    <tr>
                      <th scope="row"></th>
                      <td class="text-right font-weight-bold">Total:</td>
                      <td class="font-weight-bold">{{ $deductions->sum('price') }}</td>
                      <td></td>
                    </tr>
                      </tbody>
                    </table>
              </div>
          </div>
      </div>
      <div class="alert alert-info row" style="width:100%" role="alert">
        <div class="col text-left font-weight-bold mx-5" style="font-size: 25px;">Total Company profit: ${{ ($loads->sum('price')-($loads->sum('milage')+$loads->sum('deadhead')-$loads->sum('deadhead_d'))*$admin->permile) - $recurrings->sum('price')+($deductions->sum('price'))-$fuels->sum('price') }}</div>
        <div class="col text-right font-weight-bold mx-5" style="font-size: 25px;">Total Driver profit: ${{ ($loads->sum('milage')+$loads->sum('deadhead')-$loads->sum('deadhead_d'))*$admin->permile+$recurrings->sum('price')-($deductions->sum('price')) }}</div>
        
      </div>
      @endif
      {{-- <<<<<<<<<<<<<<<======================  Owner Drivers #owner===========================>>>>>>>>>>>>>>>>>>>>>>>> --}}
      @if ($driver->type=="owner")
      <div class="container w-100">
            <div class="row my-4">
                {{-- Loads Count --}}
                <div class="col-6 ">
                  <h3>Load Payment</h3>
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Date</th>
                          <th scope="col">Load number</th>
                          <th scope="col">Price</th>
                          <th scope="col">Fee({{ $admin->dispatch_fee }}%)</th>
                          <th scope="col">Total profit</th>
                          
                        </tr>
                       
                      </thead>
                      <tbody>
                        @php
                          $b=0;
                        @endphp
                      @foreach ($loads as $load)
                       @php
                          $b++;
                      @endphp
                      <tr>
                        <th scope="row">{{ $b }}</th>
                        <td>{{ $load->created_at }}</td>
                        <td>{{ $load->number }}</td>
                        <td class="font-weight-bold">{{ $load->price }}</td>
                        <td class="font-weight-bold">{{ $load->price*$admin->dispatch_fee/100 }}</td>
                        <td class="font-weight-bold">{{ $load->price*(100-$admin->dispatch_fee)/100 }}</td>
                       
                      </tr>
                      @endforeach
                        
                        <tr>
                          <th scope="row"></th>
                          <td colspan="2" class="text-right font-weight-bold">Total:</td>
                          <td class="font-weight-bold">{{ $loads->sum('price') }}</td>
                          <td class="font-weight-bold">{{ $loads->sum('price')*$admin->dispatch_fee/100 }}</td>
                          <td class="font-weight-bold">{{ $loads->sum('price')*(100-$admin->dispatch_fee)/100 }}</td>
                          
                         
                        </tr>
                      </tbody>
                    </table>
                </div>
                {{-- Fuel --}}
                <div class="col-6 ">
                  <h3>Fuel Payment</h3>
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">State</th>
                          <th scope="col">Date</th>
                          <th scope="col">Price</th>
                          <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="addfuel()"><i class="fas fa-plus"></i></button></th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                        $b=0;
                      @endphp
                    @foreach ($fuels as $fuel)
                     @php
                        $b++;
                    @endphp
                    <tr>
                      <th scope="row">{{ $b }}</th>
                      <td>{{ $fuel->state }}</td>
                      <td>{{ $fuel->date }}</td>
                      <td class="font-weight-bold">{{ $fuel->price }}</td>
                     <td></td>
                    </tr>
                    @endforeach
                    <tr>
                      <th scope="row"></th>
                      <td colspan="2" class="text-right font-weight-bold">Total:</td>
                      <td class="font-weight-bold">{{ $fuels->sum('price') }}</td>
                      <td></td>
                    </tr>
                      </tbody>
                    </table>
                </div>
            </div>
      
            <div class="row my-4">
                {{-- Recurring Payment --}}
              <div class="col-6 ">
                <h3>Recurring Payment</h3>
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="addrecurring()"><i class="fas fa-plus"></i></button></th>
                        </tr>
                      </thead>
                      <tbody>
                        @php
                        $b=0;
                      @endphp
                    @foreach ($recurrings as $recurring)
                     @php
                        $b++;
                    @endphp
                    <tr>
                      <th scope="row">{{ $b }}</th>
                      <td>{{ $recurring->name }}</td>
                      <td class="font-weight-bold">{{ $recurring->price }}</td>
                      <td></td>
                    </tr>
                    @endforeach
                    <tr>
                      <th scope="row"></th>
                      <td class="text-right font-weight-bold">Total:</td>
                      <td class="font-weight-bold">{{ $recurrings->sum('price') }}</td>
                      <td></td>
                    </tr>
                      </tbody>
                    </table>
              </div>
              {{-- Decuction Payment --}}
              <div class="col-6 ">
                <h3>Deduction Payment</h3>
                  <table class="table table-bordered">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Name</th>
                          <th scope="col">Price</th>
                          <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="adddeduction()"><i class="fas fa-plus"></i></button></th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Insurance</td>
                          <td class="font-weight-bold">{{ $admin->insurance }}</td>
                           <td></td>
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Fuel</td>
                          <td class="font-weight-bold">{{ $fuels->sum('price') }}</td>
                           <td></td>
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>ELD serivce</td>
                          <td class="font-weight-bold">{{ $admin->eld }}</td>
                           <td></td>
                        </tr>
                        <tr>
                          <th scope="row">4</th>
                          <td>Ifta</td>
                          <td class="font-weight-bold">{{ $admin->ifta }}</td>
                           <td></td>
                        </tr>
                      
                        
                        @php
                        $b=0;
                      @endphp
                    @foreach ($deductions as $deduction)
                     @php
                        $b++;
                    @endphp
                    <tr>
                      <th scope="row">{{ $b }}</th>
                      <td>{{ $deduction->name }}</td>
                      <td class="font-weight-bold">{{ $deduction->price }}</td>
                       <td></td>
                    </tr>
                    @endforeach
                    <tr>
                      <th scope="row"></th>
                      <td class="text-right font-weight-bold">Total:</td>
                      <td class="font-weight-bold">{{ $deductions->sum('price')+$admin->insurance+$fuels->sum('price')+$admin->eld+$admin->ifta}}</td>
                      <td></td>
                    </tr>
                      </tbody>
                    </table>
              </div>
          </div>
      </div>
      <div class="alert alert-info row" style="width:100%" role="alert">
        <div class="col text-left font-weight-bold mx-5" style="font-size: 25px;">Total Company profit: ${{ $loads->sum('price')*$admin->dispatch_fee/100-$recurrings->sum('price')+($deductions->sum('price')+$admin->insurance+$admin->eld+$admin->ifta) }}</div>
        <div class="col text-right font-weight-bold mx-5" style="font-size: 25px;">Total Driver profit: ${{ $loads->sum('price')*(100-$admin->dispatch_fee)/100+$recurrings->sum('price')-($deductions->sum('price')+$admin->insurance+$fuels->sum('price')+$admin->eld+$admin->ifta) }}</div>
        
      </div>
      @endif
    {{-- <<<<<<<<<<<<<<<======================  Lease Drivers #lease===========================>>>>>>>>>>>>>>>>>>>>>>>> --}}
      @if ($driver->type=="lease")
<div class="container w-100">
      <div class="row my-4">
          {{-- Loads Count --}}
          <div class="col-6 ">
            <h3>Load Payment</h3>
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Load number</th>
                    <th scope="col">Price</th>
                    <th scope="col">Fee({{ $admin->dispatch_fee }}%)</th>
                    <th scope="col">Total profit</th>
                    
                  </tr>
                 
                </thead>
                <tbody>
                  @php
                    $b=0;
                  @endphp
                @foreach ($loads as $load)
                 @php
                    $b++;
                @endphp
                <tr>
                  <th scope="row">{{ $b }}</th>
                  <td>{{ $load->created_at }}</td>
                  <td>{{ $load->number }}</td>
                  <td class="font-weight-bold">{{ $load->price }}</td>
                  <td class="font-weight-bold">{{ $load->price*$admin->dispatch_fee/100 }}</td>
                  <td class="font-weight-bold">{{ $load->price*(100-$admin->dispatch_fee)/100 }}</td>
                 
                </tr>
                @endforeach
                  
                  <tr>
                    <th scope="row"></th>
                    <td colspan="2" class="text-right font-weight-bold">Total:</td>
                    <td class="font-weight-bold">{{ $loads->sum('price') }}</td>
                    <td class="font-weight-bold">{{ $loads->sum('price')*$admin->dispatch_fee/100 }}</td>
                    <td class="font-weight-bold">{{ $loads->sum('price')*(100-$admin->dispatch_fee)/100 }}</td>
                    
                   
                  </tr>
                </tbody>
              </table>
          </div>
          {{-- Fuel --}}
          <div class="col-6 ">
            <h3>Fuel Payment</h3>
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">State</th>
                    <th scope="col">Date</th>
                    <th scope="col">Price</th>
                    <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="addfuel()"><i class="fas fa-plus"></i></button></th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $b=0;
                @endphp
              @foreach ($fuels as $fuel)
               @php
                  $b++;
              @endphp
              <tr>
                <th scope="row">{{ $b }}</th>
                <td>{{ $fuel->state }}</td>
                <td>{{ $fuel->date }}</td>
                <td class="font-weight-bold">{{ $fuel->price }}</td>
               <td></td>
              </tr>
              @endforeach
              <tr>
                <th scope="row"></th>
                <td colspan="2" class="text-right font-weight-bold">Total:</td>
                <td class="font-weight-bold">{{ $fuels->sum('price') }}</td>
                <td></td>
              </tr>
                </tbody>
              </table>
          </div>
      </div>

      <div class="row my-4">
          {{-- Recurring Payment --}}
        <div class="col-6 ">
          <h3>Recurring Payment</h3>
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="addrecurring()"><i class="fas fa-plus"></i></button></th>
                  </tr>
                </thead>
                <tbody>
                  @php
                  $b=0;
                @endphp
              @foreach ($recurrings as $recurring)
               @php
                  $b++;
              @endphp
              <tr>
                <th scope="row">{{ $b }}</th>
                <td>{{ $recurring->name }}</td>
                <td class="font-weight-bold">{{ $recurring->price }}</td>
                <td></td>
              </tr>
              @endforeach
              <tr>
                <th scope="row"></th>
                <td class="text-right font-weight-bold">Total:</td>
                <td class="font-weight-bold">{{ $recurrings->sum('price') }}</td>
                <td></td>
              </tr>
                </tbody>
              </table>
        </div>
        {{-- Decuction Payment --}}
        <div class="col-6 ">
          <h3>Deduction Payment</h3>
            <table class="table table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col" style="width:50px;"><button type="button" class="btn btn-primary" onclick="adddeduction()"><i class="fas fa-plus"></i></button></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Insurance</td>
                    <td class="font-weight-bold">{{ $admin->insurance }}</td>
                     <td></td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Fuel</td>
                    <td class="font-weight-bold">{{ $fuels->sum('price') }}</td>
                     <td></td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td>ELD serivce</td>
                    <td class="font-weight-bold">{{ $admin->eld }}</td>
                     <td></td>
                  </tr>
                  <tr>
                    <th scope="row">4</th>
                    <td>Ifta</td>
                    <td class="font-weight-bold">{{ $admin->ifta }}</td>
                     <td></td>
                  </tr>
                  <tr>
                    <th scope="row">5</th>
                    <td>Truck Lease</td>
                    <td class="font-weight-bold">{{ $admin->lease }}</td>
                     <td></td>
                  </tr>
                  
                  @php
                  $b=0;
                @endphp
              @foreach ($deductions as $deduction)
               @php
                  $b++;
              @endphp
              <tr>
                <th scope="row">{{ $b }}</th>
                <td>{{ $deduction->name }}</td>
                <td class="font-weight-bold">{{ $deduction->price }}</td>
                 <td></td>
              </tr>
              @endforeach
              <tr>
                <th scope="row"></th>
                <td class="text-right font-weight-bold">Total:</td>
                <td class="font-weight-bold">{{ $deductions->sum('price')+$admin->insurance+$fuels->sum('price')+$admin->eld+$admin->ifta+$admin->lease }}</td>
                <td></td>
              </tr>
                </tbody>
              </table>
        </div>
    </div>
</div>
<div class="alert alert-info row" style="width:100%" role="alert">
  <div class="col text-left font-weight-bold mx-5" style="font-size: 25px;">Total Company profit: ${{ $loads->sum('price')*$admin->dispatch_fee/100-$recurrings->sum('price')+($deductions->sum('price')+$admin->insurance+$admin->eld+$admin->ifta+$admin->lease) }}</div>
  <div class="col text-right font-weight-bold mx-5" style="font-size: 25px;">Total Driver profit: ${{ $loads->sum('price')*(100-$admin->dispatch_fee)/100+$recurrings->sum('price')-($deductions->sum('price')+$admin->insurance+$fuels->sum('price')+$admin->eld+$admin->ifta+$admin->lease) }}</div>
  
</div>
@endif


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
$('.driverId').val({{ $driver->id }});
</script>
@endsection

@section('css1')
    <style>
        
    </style>
@endsection