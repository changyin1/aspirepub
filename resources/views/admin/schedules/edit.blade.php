@extends('admin.admin_base')

@section('content')
    <div class="admin-page schedules-page mt-4">
        <h2>Schedule {{$data['schedule']->id}}</h2>
        <div class="schedule">
            @if($data['edit'])
                <div class="error"></div>
                @include('admin.schedules.edit_form')
            @else
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <div class="detail-name">Client:</div>
                            <div class="detail-name">Start Date:</div>
                            <div class="detail-name">Calls:</div>
                        </div>
                        <div class="col-3">
                            <div class="detail">{{$data['schedule']->client_name()}}</div>
                            <div class="detail">{{Carbon\Carbon::parse($data['schedule']->start_date)->format('M-d-Y')}}</div>
                            <div class="detail">{{$data['schedule']->calls}}</div>
                        </div>
                    </div>

                </div>
            @endif
            @if(!$data['calls']->isEmpty())
                <br>
                <h4>Calls</h4>
                    <table class="data-table" data-searchable="false">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Client</th>
                            <th>Due Date</th>
                            <th>Completed</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['calls'] as $call)
                            <tr class="link-row" data-href="{{route('admin/calls') . '/'.$call->id}}">
                                <td>{{$call->id}}</td>
                                <td>{{$call->client_name()}}</td>
                                <td>{{$call->due_date}}</td>
                                <td>{{$call->completed_at ? $call_completed_at : ''}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            @endif
        </div>
    </div>
@endsection