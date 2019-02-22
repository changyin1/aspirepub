@extends('base')

@section('content')
   <div class="agenda-page mt-4">
       <h2>Admin Tools</h2>
       <div class="form-group">
           <a href="/nova">Nova</a>
       </div>
       <div class="form-group">
           <a href="/admin/upload-questions">Upload Questions</a>
       </div>
       <hr class="gray"/>
       <form method="post" action="/store" enctype="multipart/form-data">
       	@csrf
       <input type="file" name="recording">       
       <input type="submit">

   </form>
   <br />
   
   @foreach($data['recordings'] as $recording)
   <a href="{{$recording->path}}{{$recording->filename}}" target="_blank">{{$recording->filename}}</a><br />
   @endforeach
   </div>
@endsection