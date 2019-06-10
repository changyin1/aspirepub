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
                            <div class="detail-name">Question Template</div>
                        </div>
                        <div class="col-3">
                            <div class="detail">{{$data['schedule']->client_name()}}</div>
                            <div class="detail">{{Carbon\Carbon::parse($data['schedule']->start_date)->format('M-d-Y')}}</div>
                            <div class="detail">{{$data['schedule']->calls}}</div>
                            <div class="detail">{{$data['schedule']->template_name()}}</div>
                        </div>
                        @if($data['sortedCalls'])
                        <div class="col-6 offset-1">
                            <div class="form-group" style="padding-top:0; margin-bottom:0">
                                <input type="hidden" id="schedule-id" value="{{$data['schedule']->id}}">
                                <input type="hidden" id="availability-url" value="{{route('getAvailable')}}">
                                <label class="control-label select-label" for="week">Week</label>
                                <select class="week" name="week" data-placeholder="Week" id="week-select" style="width: 97%">
                                    <option value="0" selected>All</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @if($data['sortedCalls'])
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <h4>Calls</h4>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary btn-submit" data-toggle="modal" data-target="#duplicateScheduleModal">Duplicate Schedule</button>
                        </div>

                    </div>
                    <br>
                    <div class="row">
                        <div class="col-6">
                            <form id="assign-specialist-form" class="assign-form ajax" data-type="specialist"
                                  action="{{route('assignCalls')}}" method="post">
                                @csrf
                                <div class="errors"></div>
                                <div class="form-group" style="margin-bottom:0">
                                    <select class="specialists" name="specialists[]" multiple="multiple"
                                            data-placeholder="No Specialist Selected" style="width: 95%">
                                    </select>
                                    <label class="control-label select-label" for="specialist">Specialists</label>
                                </div>
                                <input class="btn btn-primary btn-submit" type="submit" value="Assign Call Specialists">
                            </form>
                        </div>
                        <div class="col-6">
                            <form id="assign-coach-form" class="assign-form ajax" data-type="coach"
                                  action="{{route('assignCalls')}}" method="post">
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
                <br>
                    <div class="row">
                        <div class="col-6">
                            <button class="btn btn-primary btn-submit" data-toggle="modal" data-target="#addCallModal">Add Calls</button>
                            <button class="btn btn-primary btn-submit" data-toggle="modal" data-target="#viewCustomAgentModal">Add/Remove Custom Agents</button>
                        </div>
                    </div>
                    <table class="data-table hidden" data-week="0" data-searchable="false">
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
                        @foreach($data['sortedCalls'] as $calls)
                            @foreach($calls as $call)
                                <tr class="checkbox-row">
                                    <td><input class="checkbox" type="checkbox" name="call-id" value="{{$call->id}}"></td>
                                    <td>{{$call->id}}</td>
                                    <td>{{$call->client_name()}}</td>
                                    <td>{{$call->due_date}}</td>
                                    <td>{{$call->completed_at ? $call->completed_at : ''}}</td>
                                    <td>
                                        @foreach($call->assigned as $index => $assigned)
                                            @if($index !== 0)
                                                {{', '}}
                                            @endif
                                            {{$assigned->specialist()->name}}
                                        @endforeach
                                    </td>
                                    <td>{{$call->call_specialist() ? $call->call_specialist()->name : ''}}</td>
                                    <td>{{$call->coach() ? $call->coach()->name : ''}}</td>
                                    <td><a href="{{route('admin/calls') . '/'.$call->id}}">Edit</a></td>
                                </tr>
                            @endforeach
                        @endforeach
                        </tbody>
                    </table>
                    @foreach($data['sortedCalls'] as $index => $calls)
                        <table class="data-table hidden" data-week="{{$index}}" data-searchable="false">
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
                            @foreach($calls as $call)
                                <tr class="checkbox-row">
                                    <td><input class="checkbox" type="checkbox" name="call-id" value="{{$call->id}}"></td>
                                    <td>{{$call->id}}</td>
                                    <td>{{$call->client_name()}}</td>
                                    <td>{{$call->due_date}}</td>
                                    <td>{{$call->completed_at ? $call->completed_at : ''}}</td>
                                    <td>
                                        @foreach($call->assigned as $index => $assigned)
                                            @if($index !== 0)
                                                {{', '}}
                                            @endif
                                            {{$assigned->specialist()->name}}
                                        @endforeach
                                    </td>
                                    <td>{{$call->call_specialist() ? $call->call_specialist()->name : ''}}</td>
                                    <td>{{$call->coach() ? $call->coach()->name : ''}}</td>
                                    <td><a href="{{route('admin/calls') . '/'.$call->id}}">Edit</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endforeach
                @endif
            @endif
        </div>
    </div>
    @include('admin/modals/alert_modal', ['title' => 'Delete Schedule: '.$data['schedule']->id, 'formRoute' => route('deleteSchedule'), 'hiddenValues' => ['schedule_id' => $data['schedule']->id], 'modalId' => 'deleteScheduleModal'])
    @include('admin/modals/duplicate_schedule_modal')
    @include('admin/modals/add_call_modal')
    @include('admin/modals/view_custom_agent_modal')
@endsection