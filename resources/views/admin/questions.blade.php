@extends('admin.admin_base')

@section('content')
    <div class="admin-page questions-page mt-4">
        <h2>Questions</h2>
        <div>
            <h5 class="float-left">Here are your questions</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#newQuestionModal">
                Create New
            </button>
            <div class="clear"></div>
        </div>
        <div class="question-list">
            <table class="data-table" data-searchable="true">
                @if($data['questions']->isEmpty())
                    No Questions Created Click Here to Add One!
                @else
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Question</th>
                            <th>Type</th>
                            <th>Weight</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['questions'] as $question)
                        <tr class="link-row" data-href="{{route('admin/questions') . '/'.$question->id}}">
                            <td>{{$question->id}}</td>
                            <td>{{$question->question}}</td>
                            <td>{{$question->type}}</td>
                            <td>{{$question->weight}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    @include('admin.modals.new_question_modal')
@endsection