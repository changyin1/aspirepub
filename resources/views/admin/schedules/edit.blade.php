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
                <div class="row">
                    <div class="col-6">
                        <form id="assign-specialist-form" class="assign-form ajax" data-type="specialist" action="{{route('assignCalls')}}" method="post">
                            @csrf
                            <div class="form-group" style="margin-bottom:0">
                                <select class="specialists" name="specialists[]" multiple="multiple" data-placeholder="Specialists" style="width: 95%">
                                    @foreach($data['specialists'] as $specialist)
                                        <option value="{{$specialist->id}}">{{$specialist->name}}</option>
                                    @endforeach
                                </select>
                                <label class="control-label select-label" for="specialist">Specialists</label>
                            </div>
                            <input class="btn btn-primary btn-submit" type="submit" value="Assign Call Specialists">
                        </form>
                    </div>
                    <div class="col-6">
                        <form id="assign-coach-form" class="assign-form ajax" data-type="coach" action="{{route('assignCalls')}}" method="post">
                            @csrf
                            <div class="form-group" style="margin-bottom:0">
                                <select class="coach" name="coach" data-placeholder="Coach" style="width: 95%">
                                    @foreach($data['coaches'] as $coach)
                                        <option value="{{$coach->id}}">{{$coach->name}}</option>
                                    @endforeach
                                </select>
                                <label class="control-label select-label" for="coach">Coach</label>
                            </div>
                            <input class="btn btn-primary btn-submit" type="submit" value="Assign Coach">
                        </form>
                    </div>
                </div>
                    <table class="data-table" data-searchable="false">
                        <thead>
                        <tr>
                            <th><input class="checkbox-all" type="checkbox"></th>
                            <th>#</th>
                            <th>Client</th>
                            <th>Due Date</th>
                            <th>Completed</th>
                            <th>Assigned</th>
                            <th>Completed By</th>
                            <th>Coach</th>
                            <th>Edit</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data['calls'] as $call)
                            <tr class="checkbox-row">
                                <td><input class="checkbox" type="checkbox" name="call-id" value="{{$call->id}}"></td>
                                <td>{{$call->id}}</td>
                                <td>{{$call->client_name()}}</td>
                                <td>{{$call->due_date}}</td>
                                <td>{{$call->completed_at ? $call_completed_at : ''}}</td>
                                <td>
                                    @foreach($call->assigned as $index => $assigned)
                                        @if($index !== 0)
                                            {{', '}}
                                        @endif
                                        {{$assigned->specialist()->name}}
                                    @endforeach
                                </td>
                                <td>{{$call->call_specialist ? $call->call_specialist->name : ''}}</td>
                                <td>{{$call->coach() ? $call->coach()->name : ''}}</td>
                                <td><a href="{{route('admin/calls') . '/'.$call->id}}">Edit</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            @endif
        </div>
    </div>
@endsection