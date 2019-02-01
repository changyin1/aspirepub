@extends('base')

@section('content')
   <div class="agenda-page mt-4">
       <h2>Questions for {{$data['template']->template_name ?? ''}}</h2>      
       <hr class="gray"/>
       <div class="agenda-list">          
           @foreach ($data['questions'] as $question)
            {{$question->question}} <br/>
           @endforeach
       </div>
   </div>
@endsection