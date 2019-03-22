@extends('base')

@section('content')
   <div class="questions-page mt-4">
       <h2>Questions for Coach for {{$data['template']->template_name ?? ''}}</h2>
       <hr class="gray"/>
       <audio controls>
           <source src="horse.ogg" type="audio/ogg">
           <source src="horse.mp3" type="audio/mpeg">
           Your browser does not support the audio element.
       </audio>
       <form method="post" action="/score">
           @csrf
           <div class="form-body">
               @foreach ($data['questions'] as $question)
                   <div class="form-group">
                       <label class="control-label" for="{{$question->id}}">{{$question->question}}</label>
                       <select name="{{$question->id}}" id="{{$question->id}}" class="form-control" type="select" data-placeholder="Score">
                           <option></option>
                           @foreach (range(0, 10) as $i)
                               <option value="{{$i}}">{{$i}}</option>
                           @endforeach
                       </select>
                   </div>
               @endforeach
           </div>
       </form>
   </div>
@endsection