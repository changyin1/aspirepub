@extends('base')

@section('content')
   <div class="availability-page mt-4">
       <h2>My Availability</h2>
       <hr class="gray"/>
       <div id='calendar'></div>
       <div class="modal fade" id="availability-modal" role="dialog">
           <div class="modal-dialog">
               <!-- Modal content-->
               <div class="modal-content">
                   <div class="modal-header">
                       <h4>Submit Availability for <span class="date"></span></h4>
                       <button type="button" class="close" data-dismiss="modal">&times;</button>
                   </div>
                   <div class="modal-body">
                       <div id="form-error"></div>
                       <form class="availabilty-form">
                           <select name="available">
                               <option value="1">Available</option>
                               <option value="0">Not Available</option>
                           </select>
                           <input type="hidden" id="date" name="date" value="">
                           <input type="hidden" id='user-id' name="user-id" value="12345">
                       </form>
                   </div>
                   <div class="modal-footer">
                       <button type="submit" id="submit-availability-btn" class="btn btn-default btn-default pull-left" data-dismiss="modal">Submit</button>
                   </div>
               </div>
           </div>
       </div>
   </div>
@endsection