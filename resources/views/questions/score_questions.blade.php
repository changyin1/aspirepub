@extends('base')

@section('content')
   <div class="questions-page mt-4">
       <h2>Questions for call: {{$data['call']->id}} Question Template: {{$data['template']->template_name ?? ''}}</h2>
       <hr class="gray"/>
       <audio controls>
           <source src="horse.ogg" type="audio/ogg">
           <source src="horse.mp3" type="audio/mpeg">
           Your browser does not support the audio element.
       </audio>
       <form method="post" action="{{route('scoreCall')}}">
           @csrf
           <input type="hidden" name="callId" value="{{$data['call']->id}}">
           <div class="form-body">
               @foreach ($data['questions'] as $question)
                   @if ($question->type == 'Yes/No')
                       <div class="form-group">
                           <label class="control-label" for="{{$question->id}}">{{$question->question}}</label>
                           <select name="{{$question->id}}" id="{{$question->id}}" class="form-control" type="select" data-placeholder="Yes or No">
                               <option></option>
                               <option value="1" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id] == 1 ? 'selected' : ''}}>Yes</option>
                               <option value="0" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id] == 0 ? 'selected' : ''}}>No</option>
                           </select>
                       </div>
                   @else
                   <div class="form-group">
                       <label class="control-label" for="{{$question->id}}">{{$question->question}}</label>
                       <select name="{{$question->id}}" id="{{$question->id}}" class="form-control" type="select" data-placeholder="Score">
                           <option></option>
                           @foreach (range(0, $question->weight) as $i)
                               <option value="{{$i}}" {{isset($data['scores'][$question->id]) && $data['scores'][$question->id] == $i ? 'selected' : ''}}>{{$i}}</option>
                           @endforeach
                       </select>
                   </div>
                   @endif
               @endforeach
               <div class="form-group">
                   <input class="btn btn-primary" type="submit" value="Submit Scores">
               </div>
           </div>
       </form>
   </div>
@endsection