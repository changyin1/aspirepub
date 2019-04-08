@extends('admin.admin_base')

@section('content')
    <div class="admin-page questions-page mt-4">
        <h2>Question Templates</h2>
        <div class="question-list">
            <table>
                @if(!$data['templates'])
                    No Question Templates Created Click Here to Add One!
                @else
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Questions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($data['templates'] as $template)
                        <tr class="link-row" data-href="{{route('admin/question_templates') . '/'.$template->id}}">
                            <td>{{$template->id}}</td>
                            <td>{{$template->template_name}}</td>
                            <td>{{$template->questionCount()}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
@endsection