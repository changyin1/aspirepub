@extends('admin.admin_base')

@section('content')
    <div class="admin-page questions-page mt-4">
        <h2>Questions</h2>
        <div class="question-list">
            <table>
                @if(!$data['questions'])
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
                        <tr>
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
@endsection