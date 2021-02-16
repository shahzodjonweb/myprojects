@extends('layouts.login')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
         
                    <div class="container">

                        <form id="signup" class="form-style" action="{{ url('admin/register_user') }}" method="POST">
                    @csrf
                            <div class="header">
                            
                                <h3>Sign Up</h3>
                                
                                <p>You want to fill out this form</p>
                                
                            </div>
                            
                            <div class="sep"></div>
                    
                            <div class="inputs">
                                <input type="text" placeholder="Name" name="name" autofocus />
                                <input type="email" placeholder="E-mail" name="email"/>
                                <input type="text" placeholder="Phone" name="phone"/>
                                <input type="password" placeholder="Password" name="password"/>
                                <input type="password" placeholder="Confirm Password" name="confirm_password"/>
                                <input type="email" placeholder="Dispatcher E-mail" name="d_email"/>
                                <input type="text" placeholder="Dispatcher Password" name="dispatch_password"/>
                                <input type="text" placeholder="Default Driver Password" name="driver_password"/>
                                
                                <a id="submit" onclick="document.getElementById('signup').submit();">SIGN UP</a>
                            
                            </div>
                    
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
@endsection
