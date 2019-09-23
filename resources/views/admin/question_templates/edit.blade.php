@extends('admin.admin_base')

@section('content')
    <div class="admin-page templates-page mt-4">
        <h2>Question Template: {{$data['template']->template_name}}</h2>
        <div class="question-list">
            <div class="error"></div>
            <table id="sortable" data-sort-url="{{route('admin/question_templates/order')}}">
                @if(!$data['template']->questionCount())
                    No Questions Added Add One to Get Started!
                @else
                    <thead>
                    <tr>
                        <th>Question</th>
                        <th>Type</th>
                        <th>Weight</th>
                        <th>Order</th>
                        <th>Edit</th>
                        @if($data['edit'])
                        <th>Remove</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['template']->questions as $question)
                        <tr data-id="{{$question->id}}">
                            <td>{{$question->question->question}}</td>
                            <td>{{$question->question->type}}</td>
                            <td>{{$question->question->weight}}</td>
                            <td class="order">{{$question->order}}</td>
                            <td><a href="{{route('admin/questions') . '/'.$question->question->id}}">Edit</a></td>
                            @if($data['edit'])
                            <td><button type="button" data-question="{{$question->question->id}}" class="btn btn-danger removeQuestionFromTemplate" data-toggle="modal" data-target="#removeQuestionFromTemplateModal">
                                    Remove
                                </button></td>
                            @endif
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
            <br>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newQuestionModal">
                Create New Question
            </button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addQuestionToTemplateModal">
                Add questions
            </button>
        </div>
    </div>
    @include('admin.modals.new_question_modal')
    @include('admin/modals/add_question_modal')
    @include('admin/modals/alert_modal', ['title' => 'Removing question from template', 'formRoute' => route('removeQuestionFromTemplate'), 'hiddenValues' => ['template_id' => $data['template']->id, 'question' => '0'], 'modalId' => 'removeQuestionFromTemplateModal'])
@endsection