@extends('admin.admin_base')

@section('content')
    <div class="admin-page mt-4">
        <h2>{{$data['title']}}</h2>
        <div>
            <div>
                <a href="{{$data['route']}}"><button class="btn btn-primary mr-2">All Time</button></a>
                <a href="{{$data['route']}}/week"><button class="btn btn-primary mr-2">This Week</button></a>
                <a href="{{$data['route']}}/month"><button class="btn btn-primary">This Month</button></a>
            </div>
            <table class="data-table" data-searchable="false">
                <thead>
                <tr>
                    <th><input class="checkbox-all" type="checkbox"></th>
                    <th>#</th>
                    <th>Client</th>
                    <th>Due Date</th>
                    <th>Assigned</th>
                    <th>Coach</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['callList'] as $call)
                    <tr class="checkbox-row">
                        <td><input class="checkbox" type="checkbox" name="call-id" value="{{$call->id}}"></td>
                        <td>{{$call->id}}</td>
                        <td>{{$call->client_name()}}</td>
                        <td>{{$call->due_date}}</td>
                        <td>
                            @foreach($call->assigned as $index => $assigned)
                                @if($index !== 0)
                                    {{', '}}
                                @endif
                                {{$assigned->specialist()->name}}
                            @endforeach
                        </td>
                        <td>{{$call->coach() ? $call->coach()->name : ''}}</td>
                        <td><a href="{{route('admin/calls') . '/'.$call->id}}">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="{{route('admin/reports/incomplete')}}/week"><button class="btn btn-primary mr-2">To Be Completed</button></a>
            <a href="{{route('admin/reports/unscored')}}/week"><button class="btn btn-primary">To Be Scored</button></a>
        </div>
    </div>
@endsection