@extends('base')

@section('content')
   <div class="questions-page mt-4">
       <h2>Questions for call: {{$data['call']->id}} Question Template: {{$data['template']->template_name ?? ''}}</h2>
       <hr class="gray"/>
       <div class="questions-list">
           @foreach ($data['questions'] as $question)
            <div class="question-item">{{$question->question}}</div>
           @endforeach
       </div>
       <h4 class="form-heading">Upload Call Recording</h4>
       <form method="post" action="/store" enctype="multipart/form-data">
           @csrf
           <div class="form-body">
               <input name="file" id="file" type="file">
               <input type="submit" value="submit">
           </div>
       </form>
   </div>
@endsection