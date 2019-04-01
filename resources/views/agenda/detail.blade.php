@extends('base')

@section('content')
   <div class="agenda-page">
       <div>
           <div class="row">
               <div class="col-8">
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
                           <div class="agenda-item">
                               <div class="agenda-item-header">
                                   {{$data['calls']['client']->name}} | {{$data['calls']['client']->city}}
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
                                   @if($data['calls']['schedule']->end_date <= \Carbon\Carbon::now()->addDays(1))
                                       <div class="due-date danger"><span><i class="fas fa-exclamation-circle"></i> Due Tomorrow</span>
                                           @elseif($data['calls']['schedule']->end_date <= \Carbon\Carbon::now()->addDays(7))
                                               <div class="due-date caution"><span><i class="fas fa-exclamation-circle"></i> Due This Week</span>
                                                   @else
                                                       <div class="due-date">Due Date: {{$data['calls']->due_date}}
                                                           @endif
                                                           <a href="/schedule">Hide Details</a>
                                   </div>
                               </div>
                           </div>
                   </div>
               </div>
               <div class="col-4 border mt-5">
                   <!--
                   <div class="alert alert-warning alert-dismissible fade show" role="alert">
                       <strong>Holy guacamole!</strong> You should check in on some of those fields below.
                       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                       </button>
                   </div>
                   -->
                   <div class="form-group form-row">
                       <label class="col-md-4 control-label" for="Contact">Client</label>
                       <div class="col-md-4">
                           {{$data['calls']['client']->name}}
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-4 control-label" for="Contact">Location</label>
                       <div class="col-md-4">
                           {{$data['calls']['client']->city}}
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-4 control-label" for="Contact">Call Type</label>
                       <div class="col-md-4">
                           Group Sales
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-4 control-label" for="Contact">Phone Number</label>
                       <div class="col-md-4">
                           123-456-7890
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-4 control-label" for="Contact">Call Amount</label>
                       <div class="col-md-4">
                           $15.00
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-4 control-label" for="Contact">Status</label>
                       <div class="col-md-4">
                           @if(empty($data['calls']['completed_at']))
                               Scheduled
                               @else
                           Completed
                               @endif
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-4 control-label" for="Contact">Due Date</label>
                       <div class="col-md-4">
                           {{$data['calls']['schedule']->end_date}}
                       </div>
                   </div>
                   <form action="/schedule/post" method="post" class="form-horizontal">@
                       @csrf
                       <fieldset>
                           <div class="form-group form-row">
                               <label class="col-md-4 control-label" for="Contact">contact</label>
                               <div class="col-md-4">
                                   <input id="Contact" name="Contact" type="text" placeholder="Input Contact Name" class="form-control input-md" value="@if (!empty($data['calls']->agent_name)) {{ ucfirst(trans($data['calls']->agent_name)) }} @endif">
                               </div>
                           </div>
                           <div class="form-group form-row">
                               <label class="col-md-4 control-label" for="calltime">Call Time (at hotel)</label>
                               <div class="col-md-4">
                                   <input id="calltime" name="calltime" type="text" placeholder="Enter Time" class="form-control input-md" value="{{$data['calls']->completed_at}}">
                               </div>
                           </div>
                           <div class="form-group form-row">
                               <label class="col-md-4 control-label" for="recording">Call Recording</label>
                               <div class="col-md-4">
                                   <input id="recording" name="recording" class="input-file" type="file">
                               </div>
                           </div>
                           <div class="form-group form-row">
                               <label class="col-md-4 control-label" for="transcript">Call Transcript</label>
                               <div class="col-md-4">
                                   <input id="transcript" name="transcript" class="input-file" type="file">
                               </div>
                           </div>
                           <div class="form-group form-row">
                               <label class="col-md-4 control-label" for="caller_notes">Caller Notes</label>
                               <div class="col-md-4">
                                   <textarea id="caller_notes" name="caller_notes" class="input-file">{{$data['calls']->caller_notes}}</textarea>
                               </div>
                           </div>
                           <div class="form-group form-row">
                               <label class="col-md-4 control-label" for="cancellation">Cancellation</label>
                               <div class="col-md-4">
                                   <label class="checkbox-inline" for="cancellation-0">
                                       <input type="checkbox" name="cancellation" id="cancellation-0" value="1" data-toggle="button">
                                   </label>
                               </div>
                           </div>
                           <div class="form-group form-row">
                               <div class="col-md-4">
                                   <input class="btn btn-primary" type="submit" value="POST CALL">
                                   <a  class="btn btn-primary" href="/questions/template/{{$data['calls']['Schedule']->questionstemplates_id}}">VIEW QUESTIONS</a>
                               </div>
                           </div>

                       </fieldset>
                       <input type="hidden" name="call_id" value="{{$data['calls']->id}}">
                   </form>
               </div>
           </div>
       </div>
   </div>
@endsection