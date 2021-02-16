{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.app')


@section('content')

    <div class="wrapper">
        <div class="tabs">
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch" onclick="location.href='{{ route('broker.index') }}'">
            <label for="tab-1" class="tab-label">Broker List</label>
            <div class="tab-content">
            {{-- All Content --}}
            @yield('content1')
            {{-- End of content --}}
             </div>
          </div>
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-2" class="tab-switch" onclick="location.href='{{ route('broker.create') }}'">
            <label for="tab-2" class="tab-label">Add Broker</label>
           </div>
         
        </div>
       
    </div>
      



@endsection

@section('js')
<script>
  
  $('.broker').addClass('active');
</script>
   @yield('js1')
@endsection

@section('css')
    @yield('css1')
@endsection
