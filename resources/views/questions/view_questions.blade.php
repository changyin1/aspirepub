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
       <form class="ajax" method="post" action="{{route('completeCall')}}" enctype="multipart/form-data">
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
                   <input type="text" name="link" id="link" placeholder="Drop box link">
               </div>
               <input name="file" id="file" type="file">
               <input type="submit" value="Mark Call As Done">
           </div>
       </form>
   </div>
   @include('admin.modals.success_modal')
@endsection