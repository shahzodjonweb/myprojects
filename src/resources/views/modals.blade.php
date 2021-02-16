
      {{-- Delete modal for drivers --}}
      <div class="modal d-none" id="deleteDriver" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete driver</h5>
              <button type="button" class="close" data-dismiss="modal" onclick="modalFade()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Do you want to delete?
            </div>
            <div class="modal-footer d-flex justify-content-start">
              <form action="{{ url('driver/deleteDriver') }}" method="post" class="deleteDriverForm">
                @csrf
                <input type="hidden" name="id" id="id_driver_delete">
              <button type="submit" class="btn btn-danger" data-dismiss="modal">Delete</button>
            </form>
              <button type="button" class="btn btn-info" onclick="modalFade()">Exit</button>
            </div>
          </div>
        </div>
      </div>

       {{-- Delete modal for Loads --}}
       <div class="modal d-none" id="deleteLoad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Delete load</h5>
              <button type="button" class="close" onclick="modalFade()" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Do you want to delete?
            </div>
            <div class="modal-footer d-flex justify-content-start">
              <form action="{{ url('load/deleteLoad') }}" method="post">
                @csrf
                <input type="hidden" name="id" id="id_load_delete">
              <button type="submit" class="btn btn-danger" data-dismiss="modal">Delete</button>
            </form>
              <button type="button" class="btn btn-info" onclick="modalFade()">Exit</button>
            </div>
          </div>
        </div>
      </div>
         {{-- Add expences to drivers --}}
         <div class="modal d-none" id="addexpence" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title modalexpence" id="exampleModalLabel">Add Fuel</h5>
                <button type="button" class="close" onclick="modalFade()" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              {{-- Fuel form --}}
              <div  class="fuelform d-none">
              <form action="{{ url('report/addfuel') }}" method="post">
                @csrf
                <input type="hidden" name="driverId" class="driverId">
              <div class="modal-body">
                <div class="form-group row">
                  <label for="staticEmail" class="col-sm-2 col-form-label">Date</label>
                  <div class="col-sm-10">
                    <input type="date"  class="form-control" id="fueldate" name="date">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">State</label>
                  <div class="col-sm-10">
                  
                    <select class="form-control" id="fuelstate" name="state">
                      <option value="AL">AL</option>
                      <option value="AK">AK</option>
                      <option value="AR">AR</option>	
                      <option value="AZ">AZ</option>
                      <option value="CA">CA</option>
                      <option value="CO">CO</option>
                      <option value="CT">CT</option>
                      <option value="DC">DC</option>
                      <option value="DE">DE</option>
                      <option value="FL">FL</option>
                      <option value="GA">GA</option>
                      <option value="HI">HI</option>
                      <option value="IA">IA</option>	
                      <option value="ID">ID</option>
                      <option value="IL">IL</option>
                      <option value="IN">IN</option>
                      <option value="KS">KS</option>
                      <option value="KY">KY</option>
                      <option value="LA">LA</option>
                      <option value="MA">MA</option>
                      <option value="MD">MD</option>
                      <option value="ME">ME</option>
                      <option value="MI">MI</option>
                      <option value="MN">MN</option>
                      <option value="MO">MO</option>	
                      <option value="MS">MS</option>
                      <option value="MT">MT</option>
                      <option value="NC">NC</option>	
                      <option value="NE">NE</option>
                      <option value="NH">NH</option>
                      <option value="NJ">NJ</option>
                      <option value="NM">NM</option>			
                      <option value="NV">NV</option>
                      <option value="NY">NY</option>
                      <option value="ND">ND</option>
                      <option value="OH">OH</option>
                      <option value="OK">OK</option>
                      <option value="OR">OR</option>
                      <option value="PA">PA</option>
                      <option value="RI">RI</option>
                      <option value="SC">SC</option>
                      <option value="SD">SD</option>
                      <option value="TN">TN</option>
                      <option value="TX">TX</option>
                      <option value="UT">UT</option>
                      <option value="VT">VT</option>
                      <option value="VA">VA</option>
                      <option value="WA">WA</option>
                      <option value="WI">WI</option>	
                      <option value="WV">WV</option>
                      <option value="WY">WY</option>
                    </select>		
                  </div>
                </div>

                <div class="form-group row">
                  <label for="inputPassword" class="col-sm-2 col-form-label">Price</label>
                  <div class="col-sm-10">
                  
                    <input type=number step=0.01 class="form-control" id="fuelprice" name="price">
                   
                  </div>
                </div>
              </div>
              <div class="modal-footer d-flex justify-content-start">
                <button type="submit" class="btn btn-info" data-dismiss="modal">Save</button>
                <button type="button" class="btn btn-danger" onclick="modalFade()">Exit</button>
              </div>
              </form>
            </div>
                 {{-- Recurring form --}}
                 <div class="recurringform d-none">
                 <form action="{{ url('report/addrecurring') }}" method="post" >
                  @csrf
                  <input type="hidden" name="driverId" class="driverId">
                <div class="modal-body">
                  
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-10">
                    
                      <input type=text class="form-control" id="recurringname" name="name">
                    </div>
                  </div>
  
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Price</label>
                    <div class="col-sm-10">
                    
                      <input type=number step=0.01 class="form-control" id="recurringprice" name="price">
                     
                    </div>
                  </div>
                </div>
                <div class="modal-footer d-flex justify-content-start">
                  <button type="submit" class="btn btn-info" data-dismiss="modal">Save</button>
                  <button type="button" class="btn btn-danger" onclick="modalFade()">Exit</button>
                </div>
                </form>
              </div>
                  {{-- Deduction form --}}
                  <div class="deductionform d-none">
                  <form action="{{ url('report/adddeduction') }}" method="post" >
                    @csrf
                    <input type="hidden" name="driverId" class="driverId">
                  <div class="modal-body">
                    
                    <div class="form-group row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">Name</label>
                      <div class="col-sm-10">
                      
                        <input type=text class="form-control" id="deductionname" name="name">
                      </div>
                    </div>
    
                    <div class="form-group row">
                      <label for="inputPassword" class="col-sm-2 col-form-label">Price</label>
                      <div class="col-sm-10">
                      
                        <input type=number step=0.01 class="form-control" id="deductionprice" name="price">
                       
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer d-flex justify-content-start">
                    <button type="submit" class="btn btn-info" data-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-danger" onclick="modalFade()">Exit</button>
                  </div>
                  </form>
                </div>
             
            </div>
          </div>
        </div>



        {{-- Add Broker --}}

          <div class="modal d-none" id="addBroker" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title modalexpence" id="exampleModalLabel">Add Broker</h5>
                  <button type="button" class="close" onclick="modalFade()" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
  
                   
                    <div class="deductionform">
                      <form  action="{{ url('broker/addBroker') }}" enctype="multipart/form-data" method="post" id="submitbroker">
                        @csrf
                    <div class="ui-container ui-12w">
                      
                     <div class="alert-show-broker"></div>
                        <div class="row mt-3">
                          <div class="form-group col">
                            <input type="text" class="form-control" id="brokername" name="name" placeholder="Company name">
                          </div>
                          
                        </div>
                          
                  
                
                
                            
                                <div class="row mt-3">
                                    <label for="phone" class="col-form-label col-3 font-weight-bold">Phone</label>
                                    <div class="col-9">
                                      <div class="input-group">
                                        <div class="input-group-prepend ">
                                          <span class="input-group-text">+1</span>
                                        </div>
                                        <input type="text" class="form-control" id="brokerphone" name="phone" placeholder="(123) 456-7890" oninput="formatnumber()" value="{{ old('phone') }}">
                                      </div>
                                    </div>
                                   
                                  </div>
                                  <div class="row mt-3">
                                    <label for="phone" class="col-form-label col-3 font-weight-bold">Fax</label>
                                    <div class="col-9">
                                      <div class="input-group">
                                        <div class="input-group-prepend ">
                                          <span class="input-group-text">+1</span>
                                        </div>
                                        <input type="text" class="form-control" id="brokerfax" name="fax" placeholder="(123) 456-7890" oninput="formatnumber2()" value="{{ old('fax') }}">
                                      </div>
                                    </div>
                                   
                                  </div>
                             
                                  <div class="form-group  mt-3">
                                    <input type="email" class="form-control" id="brokeremail" name="email" placeholder="Email" value="{{ old('email') }}">
                                  </div>
                                  <div class="form-group   mt-3">
                                    <input type="text" name="address" id="brokeraddress" placeholder="Address" class="form-control" value="{{ old('address') }}">
                                  </div>

                                  <div class="row mt-3">
                                    <label for="phone" class="col-form-label col-3 font-weight-bold">MC#</label>
                                    <div class="col-9 form-group">
                                      <input type="text" class="form-control" id="brokermc" name="mc"  value="{{ old('mc') }}">
                                    </div>
                                  </div>

                                  <div class="row mt-3">
                                    <label for="dot" class="col-form-label col-3 font-weight-bold">DOT#</label>
                                    <div class="col-9 form-group">
                                      <input type="text" class="form-control" id="brokerdot" name="dot" value="{{ old('dot') }}">
                                    </div>
                                  </div>
                           
                              <div class="row d-flex flex-row-reverse justify-content-center">
                                <button type="button" class="btn btn-success mr-2 btn-block btn-lg mt-3 mb-3 w-50 font-weight-bold " onclick="checkbroker()">Add</button>
                              </div>
                    </div>
                    </form>
                  </div>
               
              </div>
            </div>
          </div>
  
