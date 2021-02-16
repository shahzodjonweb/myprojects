{{-- <<<<<< In this page Managers can check All statistics >>>>>> --}}
@extends('layouts.app')


@section('content')

    <div class="wrapper">
        <div class="tabs">
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-1" checked class="tab-switch" onclick="location.href='{{ url('driver/activedrivers') }}'">
            <label for="tab-1" class="tab-label">Live Board</label>
            <div class="tab-content">
            {{-- All Content --}}
            @yield('content1')
            {{-- End of content --}}
             </div>
          </div>
          
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-3" class="tab-switch" onclick="location.href='{{ url('load/activeloads') }}'">
            <label for="tab-3" class="tab-label"> Live Loads</label>
            <!-- <div class="tab-content">When I left Mr. Bates, I went down to my father: where, by the assistance of him and my uncle John, and some other relations, I got forty pounds, and a promise of thirty pounds a year to maintain me at Leyden: there I studied physic two years and seven months, knowing it would be useful in long voyages.</div> -->
          </div>
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-2" class="tab-switch" onclick="location.href='{{ route('load.create') }}'">
            <label for="tab-2" class="tab-label">New Load</label>
            <!-- <div class="tab-content">My father now and then sending me small sums of money, I laid them out in learning navigation, and other parts of the mathematics, useful to those who intend to travel, as I always believed it would be, some time or other, my fortune to do. </div> -->
          </div>
          {{-- <div class="tab">
            <input type="radio" name="css-tabs" id="tab-4" class="tab-switch" onclick="location.href='{{url('customerlist/credit_tech')}}'">
            <label for="tab-4" class="tab-label"></label>
            <!-- <div class="tab-content">When I left Mr. Bates, I went down to my father: where, by the assistance of him and my uncle John, and some other relations, I got forty pounds, and a promise of thirty pounds a year to maintain me at Leyden: there I studied physic two years and seven months, knowing it would be useful in long voyages.</div> -->
          </div>
          <div class="tab">
            <input type="radio" name="css-tabs" id="tab-5" class="tab-switch" onclick="location.href='{{ route('check.index') }}'">
            <label for="tab-5" class="tab-label">Kredit So'ndirish</label>
            <!-- <div class="tab-content">When I left Mr. Bates, I went down to my father: where, by the assistance of him and my uncle John, and some other relations, I got forty pounds, and a promise of thirty pounds a year to maintain me at Leyden: there I studied physic two years and seven months, knowing it would be useful in long voyages.</div> -->
          </div> --}}

         

          {{-- <div class="tab">
            <input type="radio" name="css-tabs" id="tab-6" class="tab-switch" onclick="location.href='{{ route('adminpanel.edit',1) }}'">
            <label for="tab-6" class="tab-label">Admin Panel</label>
            <!-- <div class="tab-content">When I left Mr. Bates, I went down to my father: where, by the assistance of him and my uncle John, and some other relations, I got forty pounds, and a promise of thirty pounds a year to maintain me at Leyden: there I studied physic two years and seven months, knowing it would be useful in long voyages.</div> -->
          </div> --}}
        </div>
       
      </div>
      



@endsection

@section('js')
<script>
  
  $('.dashboard').addClass('active');

</script>
   @yield('js1')
@endsection

@section('css')
    @yield('css1')
@endsection
