@extends('admin.admin_base')

@section('content')
    <div class="admin-page questions-page mt-4">
        <h2>Question Template {{$data['template']->name}}</h2>
        <div class="question-list">
            <div class="error"></div>
            <table id="sortable" data-sort-url="{{route('admin/question_templates/order')}}">
                @if(!$data['template']->questionCount())
                    No Questions Added Click Here to Add One!
                @else
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Type</th>
                        <th>Weight</th>
                        <th>Order</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['template']->questions as $question)
                        <tr data-id="{{$question->id}}">
                            <td>{{$question->question->id}}</td>
                            <td>{{$question->question->question}}</td>
                            <td>{{$question->question->type}}</td>
                            <td>{{$question->question->weight}}</td>
                            <td class="order">{{$question->order}}</td>
                            <td><a href="{{route('admin/questions')}}">Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
@endsection