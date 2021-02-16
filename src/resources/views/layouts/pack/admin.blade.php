{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.app')


@section('content')

    <div class="wrapper">
        <div class="tabs">
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch" onclick="location.href='{{ route('admin.index') }}'">
            <label for="tab-1" class="tab-label">General Settings</label>
            <div class="tab-content">
            {{-- All Content --}}
            @yield('content1')
            {{-- End of content --}}
             </div>
          </div>
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-2" class="tab-switch" onclick="location.href='{{ url('admin/payment') }}'">
            <label for="tab-2" class="tab-label">Payment Settings</label>
           </div>
         
        </div>
       
    </div>
      



@endsection

@section('js')
<script>
  
  $('.admin').addClass('active');
</script>
   @yield('js1')
@endsection

@section('css')
    @yield('css1')
@endsection
