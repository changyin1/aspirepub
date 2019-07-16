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
       @endif
       <form method="post" action="{{route('scoreCall')}}">
           @csrf
           <input type="hidden" name="callId" value="{{$data['call']->id}}">
           <div class="form-body">
               @foreach ($data['questions'] as $question)
                   <div class="form-group">
                       <label class="control-label" for="{{$question->id}}">{{$question->question}}</label>
                       <select name="score[{{$question->id}}]" id="{{$question->id}}" class="form-control" type="select" data-placeholder="Yes or No">
                           <option></option>
                           <option value="1" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id]['score'] == 1 ? 'selected' : ''}}>Yes</option>
                           <option value="0" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id]['score'] == 0 ? 'selected' : ''}}>No</option>
                           <option value="-1" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id]['score'] == 0 ? 'selected' : ''}}>N/A</option>
                       </select>
                   </div>
               @endforeach
               <div class="form-group">
                   <label class="control-label" for="call-notes">Notes</label>
                   <textarea class="form-control" name="note" rows="5" placeholder="Type notes here...">{{$data['call']->coach_notes}}</textarea>
               </div>
               <div class="form-group">
                   <input class="btn btn-primary" type="submit" value="Submit Scores">
               </div>
           </div>
       </form>
   </div>
@endsection