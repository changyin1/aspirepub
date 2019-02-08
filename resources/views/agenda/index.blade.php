@extends('base')

@section('content')
   <div class="agenda-page mt-4">
       <h2>Call Agenda for {{$data['user']->name ?? ''}}</h2>
       <div class="form-group">
           <label for="view">View</label>
           <select name="view">
               <option value="1">All</option>
               <option value="2">Due This Week</option>
               <option value="3">Due Tomorrow</option>
           </select>
       </div>
       <hr class="gray"/>
       <div class="agenda-list">
           @foreach($data['calls'] as $agenda)
               <div class="agenda-item">
                   <div class="agenda-item-header">
                       {{$agenda['client']->name}} | {{$agenda['client']->city}}
                   </div>
                   <hr/>
                   <div class="agenda-item-details">
                       <div class="agenda-item-detail">
                           <span>Contact</span>
                           <span class="black-text">Contact Name</span>
                       </div>
                       <div class="agenda-item-detail">
                           <span>Phone Number</span>
                           <span class="black-text">123-456-7890</span>
                       </div>
                       <div class="agenda-item-detail">
                           <span>Call Amount</span>
                           <span class="black-text">$15.00</span>
                       </div>
                   </div>
                   <div class="agenda-item-footer">
                       @if($agenda['schedule']->end_date <= \Carbon\Carbon::now()->addDays(1))
                           <div class="due-date danger"><span><i class="fas fa-exclamation-circle"></i> Due Tomorrow</span>
                       @elseif($agenda['schedule']->end_date <= \Carbon\Carbon::now()->addDays(7))
                           <div class="due-date caution"><span><i class="fas fa-exclamation-circle"></i> Due This Week</span>
                       @else
                           <div class="due-date">Due Date: {{$agenda['schedule']->end_date}}
                       @endif
                       <a href="/schedule/detail/{{$agenda['id']}}">View Details</a>
                       </div>
                   </div>
               </div>
           @endforeach
       </div>
   </div>
@endsection