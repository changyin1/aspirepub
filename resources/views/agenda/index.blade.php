@extends('base')

@section('content')
   <div class="agenda-page mt-4">
       <h2>Call Agenda for {{$data['user']->name ?? ''}}</h2>
       <div class="form-group">
           <label for="view">View</label>
           <select name="view" id="agenda-view">
               <option value="1">All</option>
               <option value="2">Due This Week</option>
               <option value="3">Due Tomorrow</option>
           </select>
       </div>
       <hr class="gray"/>
       <div class="agenda-list">
           @foreach($data['calls'] as $call)
               <div class="agenda-item" data-item="{{$call->due()}}">
                   <div class="agenda-item-header row">
                       <div class="col-11">{{$call['client']->name}} | {{$call['client']->city}}</div>
                       @if(!$call->claimed())
                       <div class="col-1 align-right"><button class="btn btn-success claim-call-btn" data-call="{{$call->id}}" data-url="{{route('claimCall')}}">Accept</button></div>
                       @endif
                   </div>
                   <hr/>
                   <div class="agenda-item-details">
                       <div class="agenda-item-detail">
                           <span>Contact</span>
                           <span class="black-text">Contact Name</span>
                       </div>
                       <div class="agenda-item-detail">
                           <span>Phone Number</span>
                           <span class="black-text">{{$call['client']->phone_number}}</span>
                       </div>
                       <div class="agenda-item-detail">
                           <span>Call Amount</span>
                           <span class="black-text">$15.00</span>
                       </div>
                   </div>
                   <div class="agenda-item-footer">
                       @if($data['user']->role == 'call_specialist' || $data['user']-> role == 'admin')
                           @if($call->completed_at)
                               <div class="due-date success">Completed: {{date_format(date_create($call->completed_at), 'Y-m-d')}}
                           @elseif($call->due_date <= \Carbon\Carbon::now()->addDays(1))
                               <div class="due-date danger"><span><i class="fas fa-exclamation-circle"></i> Due Tomorrow</span>
                           @elseif($call->due_date <= \Carbon\Carbon::now()->addDays(7))
                               <div class="due-date caution"><span><i class="fas fa-exclamation-circle"></i> Due This Week</span>
                           @else
                               <div class="due-date">Due Date: {{$call->due_date}}
                           @endif
                           <a href="/schedule/detail/{{$call['id']}}">View Details</a>
                           </div>
                       @endif
                       @if($data['user']->role == 'coach' || $data['user']-> role == 'admin')
                           @if($call->completed_at)
                               <div class="due-date"><a href="{{route('scoreCallView', ['id' => $call['id']])}}">Score Call</a></div>
                           @else
                               <div class="due-date">Call not yet completed</div>
                           @endif
                       @endif
                   </div>
               </div>
           @endforeach
       </div>
   </div>
   <script type="text/javascript">
       $(document).ready(function () {
           $('#agenda-view').on('change', function (){
               if ($(this).val() == 1) {
                   $('.agenda-item').show();
               } else {
                   $('.agenda-item').hide();
                   $('.agenda-item[data-item="'+ $(this).val()  +'"]').show();
               }
           });
           $('.claim-call-btn').click(function (e) {
               e.preventDefault();
               let $this = $(this);
               $.ajax({
                   type: "POST",
                   url: $(this).data('url'),
                   data: { id: $(this).data('call')},
                   success: function (response) {
                       if (response.success) {
                           alert('Successfully claimed this call assignment')
                           $this.hide();
                       } else {
                           alert('Error claiming call, this assignment may have been claimed already please try again')
                       }
                       $(this).hide();
                   },
                   error: function (response) {
                       alert('Error claiming call, this assignment may have been claimed already please try again')
                   }
               });
           });
       });
   </script>
@endsection
