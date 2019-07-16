@extends('admin.admin_base')

@section('content')
    <div class="admin-page templates-page mt-4">
        <h2>Question Templates</h2>
        <div>
            <h5 class="float-left">Here are your schedules</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#newQuestionTemplateModal">
                Create New
            </button>
            <div class="clear"></div>
        </div>
        <div class="question-list">
            <table class="data-table">
                @if($data['templates']->isEmpty())
                    No Question Templates Created Click Here to Add One!
                @else
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Questions</th>
                            <th>Used</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['templates'] as $template)
                        <tr class="link-row" data-href="{{route('admin/question_templates') . '/'.$template->id}}">
                            <td>{{$template->id}}</td>
                            <td>{{$template->template_name}}</td>
                            <td>{{$template->questionCount()}}</td>
                            <td>{{$template->active ? 'Yes' : 'No'}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    @include('admin/modals/new_template_modal')
@endsection