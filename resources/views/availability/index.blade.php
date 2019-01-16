@extends('base')

@section('content')
   <div class="availability-page mt-4">
       <h2>My Availability</h2>
       <hr class="gray"/>
       <div id='calendar'></div>
       <input type="hidden" id="date" name="date" value="">
       <input type="hidden" id='user-id' name="user-id" value="12345">
   </div>
@endsection