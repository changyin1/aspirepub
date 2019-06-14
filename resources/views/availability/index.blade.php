@extends('base')

@section('content')	
   <div class="availability-page mt-4">
       <h2>My Availability</h2>
       <hr class="gray"/>
       <div class="row">
           <div class="legend mb-4 col-10">
               <h5>Legend</h5>
               <div class="legend-item">
                   <span class="legend-unavailable"></span> Unavailable
               </div>
               <div class="legend-item">
                   <span class="legend-available"></span> Available
               </div>
               <div class="legend-item">
                   <span class="legend-today"></span> Today
               </div>
           </div>
           <div class="col-2">
               <div class="form-group">
                   <label class="control-label select-label" for="max">Max Calls Per Week</label>
                   <select class="max noclear" id="max" name="max" data-placeholder="Max number of calls for week" style="width: 100%">
                       <option></option>
                       @foreach(range(1, 20) as $max)
                           <option value="{{$max}}"
                           @if($max == 1)
                               selected
                           @endif
                           >{{$max}}</option>
                       @endforeach
                   </select>
               </div>
           </div>
       </div>
       <div id='calendar'></div>
       <input type="hidden" id="date" name="date" value="">
       <input type="hidden" id='user-id' name="user-id" value="{{$data['user']->id}}">
       <input type="hidden" id="availability-url" value="{{url('/api/availability')}}">
   </div>
@endsection