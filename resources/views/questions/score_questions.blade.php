@extends('base')

@section('content')
   <div class="questions-page mt-4">
       <h2>Questions for call: {{$data['call']->id}} Question Template: {{$data['template']->template_name ?? ''}}</h2>
       <hr class="gray"/>
       @if($data['recording'])

       <audio controls>
           <source src="{{$data['recording']}}" type="audio/ogg">
           <source src="{{$data['recording']}}" type="audio/mpeg">
           Your browser does not support the audio element.
       </audio>
       <a class="ml-4" target="_blank" href="{{$data['recording']}}">Direct Link to Recording</a>
       @endif
       <form method="post" action="{{route('scoreCall')}}">
           @csrf
           <input type="hidden" name="callId" value="{{$data['call']->id}}">
           <div class="form-body row">
               <div class="col-6">
                   @foreach ($data['questions'] as $question)
                       <div class="form-group">
                           <label class="control-label" for="{{$question->id}}">{{$question->question}}</label>
                           <select name="score[{{$question->id}}]" id="{{$question->id}}" class="form-control" type="select" data-placeholder="Yes or No">
                               <option value="1" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id]['score'] == 1 ? 'selected' : ''}}>Yes</option>
                               <option value="0" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id]['score'] == 0 ? 'selected' : ''}}>No</option>
                               <option value="-1" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id]['score'] == -1 ? 'selected' : ''}}>N/A</option>
                           </select>
                       </div>
                   @endforeach
                   <div class="form-group">
                       <label class="control-label" for="engagement">Engagement Score</label>
                       <select class="form-control" id="engagement" name="engagement" data-placeholder="Engagement Score">
                           @for ($i = 1; $i <= 5; $i++)
                               <option value="{{$i}}" {{$data['call']->call_score == $i ? 'selected' : ''}}>{{$i}}</option>
                           @endfor
                       </select>
                   </div>
                   <div class="form-group">
                       <label class="control-label" for="call-notes">Notes</label>
                       <textarea class="form-control" name="note" rows="5" placeholder="Type notes here...">{{$data['call']->coach_notes}}</textarea>
                   </div>
                   <div class="form-group">
                       <input class="btn btn-primary" type="submit" value="Submit Scores">
                   </div>
               </div>

               <div class="col-6">
                   <h5 class="form-heading">Call details for {{$data['call']['client']->name}}</h5>
                   <hr class="mb-4">
                   <div class="form-group form-row">
                       <label class="col-md-6 control-label" for="Contact">Client</label>
                       <div class="col-md-6">
                           {{$data['call']['client']->name}}
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-6 control-label" for="Contact">Location</label>
                       <div class="col-md-6">
                           {{$data['call']['client']->city}}
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-6 control-label" for="Contact">Phone Number</label>
                       <div class="col-md-6">
                           {{$data['call']['client']->phone_number}}
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-6 control-label" for="Contact">Status</label>
                       <div class="col-md-6">
                           @if(empty($data['call']['completed_at']))
                               Scheduled
                           @else
                               Completed: {{date_format(date_sub(date_create($data['call']->completed_at), date_interval_create_from_date_string("1 day")), 'Y-m-d')}}
                           @endif
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-6 control-label" for="Contact">Due Date</label>
                       <div class="col-md-6">
                           {{$data['call']->due_date}}
                       </div>
                   </div>
                   <div class="form-group form-row">
                       <label class="col-md-6 control-label" for="agent">Agent Reached</label>
                       <input class="col-md-6 no-anim form-control" type="text" name="agent" id="agent" value="{{$data['call']->agent_name}}">
                   </div>
               </div>
           </div>
       </form>
   </div>
@endsection