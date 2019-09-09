@extends('base')

@section('content')
   <div class="questions-page my-4">
       <h2>Call: {{$data['call']->id}} Question Template: {{$data['template']->template_name ?? ''}}</h2>
       <hr class="gray"/>
       {{--<div class="questions-list">--}}
           {{--@foreach ($data['questions'] as $question)--}}
            {{--<div class="question-item">{{$question->question}}</div>--}}
           {{--@endforeach--}}
       {{--</div>--}}
       <h4 class="form-heading">Upload Call Recording</h4>
       @if($data['attachments'])
           @foreach($data['attachments'] as $key => $attachment)
               <a target="_blank" href="{{$attachment->attachment_link_address}}"><p class="btn btn-primary">Schedule Attachment {{$key}}</p></a>
           @endforeach
       @endif
       <form method="post" action="{{route('completeCall')}}" enctype="multipart/form-data">
           @csrf
           <input type="hidden" name="id" value="{{$data['call']->id}}">
           <input type="hidden" id="redirect" value="{{route('schedule')}}">
           <div class="form-body">
               @if(!$data['call']->schedule->customAgentsNotContacted->isEmpty())
                   <div class="form-group">
                       <label class="control-label select-label" for="agent">Custom Agent</label>
                       <select class="agent" name="agent" data-placeholder="Custom Agent" style="width: 95%">
                           <option></option>
                           @foreach($data['call']->schedule->customAgentsNotContacted as $agent)
                               <option value="{{$agent->id}}">{{$agent->agent_name}}</option>
                           @endforeach
                       </select>
                   </div>
               @endif
               <div class="form-group">
                   <label class="control-label select-label" for="link">File Link</label>
                   <input type="text" name="link" id="link" class="no-anim" placeholder="Drop box link">
               </div>
               <div class="form-group">
                   <label class="control-label select-label" for="call_completed_at">Call Completed Time</label>
                   <input type="text" class="datepicker-time no-anim" name="call_completed_at" id="call_completed_at" value="{{$data['call']->completed_at}}">
               </div>
               <div class="form-group">
                   <label class="control-label select-label" for="call_receiver">Name of Call Receiver</label>
                   <input type="text" class="no-anim" name="call_receiver" id="call_receiver" value="{{$data['call']->agent_name}}">
               </div>
               <div class="form-group">
                   <input type="checkbox" class="no-anim" name="reservation_made" id="reservation_made">
                   <label class="control-label select-label checkbox-label" for="reservation_made" value="{{$data['call']->reservation_made}}">Reservation Made</label>
               </div>
               <div class="form-group">
                   <label class="control-label select-label" for="reservation_start">Reservation Start Date</label>
                   <input type="text" class="datepicker no-anim" name="reservation_start" id="reservation_start" value="{{$data['call']->arrival_date}}">
               </div>
               <div class="form-group">
                   <label class="control-label select-label" for="reservation_end">Reservation End Date</label>
                   <input type="text" class="datepicker no-anim" name="reservation_end" id="reservation_end" value="{{$data['call']->departure_date}}">
               </div>
               <div class="form-group">
                   <label class="control-label select-label" for="confirmation_number">Confirmation Number</label>
                   <input type="text" class="no-anim" name="confirmation_number" id="confirmation_number" value="{{$data['call']->reservation_confirmation}}">
               </div>
               <div class="form-group">
                   <input type="checkbox" class="no-anim" name="card_used" id="card_used" @if($data['call']->aspire_card_used){{'checked'}}@endif>
                   <label class="control-label select-label checkbox-label" for="card_used">Aspire Credit Card Used</label>
               </div>
               <div class="form-group">
                   <label class="control-label select-label" for="file">Upload Call Recording</label>
                   <input class="no-anim" name="file" id="file" type="file">
               </div>
               <button class="btn btn-primary">Submit call as completed</button>
           </div>
       </form>
   </div>
   @include('admin.modals.success_modal')
@endsection