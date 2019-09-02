@extends('admin.admin_base')

@section('content')
    <div class="admin-page calls-page mt-4">
        <h2>Call {{$data['call']->id}}</h2>
        <div class="call">
            <h5>Client</h5>
            <p><a href="{{route('admin/clients') . '/'.$data['call']->client_id}}">{{$data['call']->client_name()}}</a></p>
            <h5>Schedule</h5>
            @if($data['call']->schedule)
            <p><a href="{{route('admin/schedules') . '/' .$data['call']->schedule->id}}}">{{$data['call']->schedule->id}}</a></p>
            @else
            <p>This call's schedule has been deleted</p>
            @endif
            <h5>Completed</h5>
            <p>{{$data['call']->completed_at ? $data['call']->completed_at . ' by : ' . $data['call']->call_specialist()->name : 'Not complete'}}</p>
            <h5>Due Date</h5>
            <p>{{$data['call']->due_date}}</p>
            <h5>Currently Assigned To</h5>
            <p>
                @if(!$data['assigned'])
                    None
                @endif
                @foreach($data['assigned'] as $assigned)
                    {{$assigned->name}}
                @endforeach
            </p>
            @if(!$data['call']->completed_at)
            <form id="edit-schedule-form" class="edit-form ajax" action="{{route('assignCall')}}" method="post">
                @csrf
                <div class="errors" style="width: 66.67%"></div>
                @if($data['call']->schedule)
                <input type="hidden" id="schedule-id" value="{{$data['call']->schedule->id}}">
                <input type="hidden" id="redirect" value="{{route('admin/schedules/edit', ['id' => $data['call']->schedule->id])}}">
                @endif
                <input type="hidden" id="week-select" value="{{$data['call']->week()}}">
                <input type="hidden" id="availability-url" value="{{route('getAvailable')}}">
                <input type="hidden" id="id" name="id" value="{{$data['call']->id}}">
                <div class="form-body">
                    <div class="form-group">
                        <select class="coach" name="coach" data-placeholder="Coach" style="width: 66.67%">
                            <option></option>
                            @foreach($data['coaches'] as $coach)
                                <option value="{{$coach->id}}"
                                        @if($data['call']->coach == $coach->id)
                                        selected
                                        @endif
                                >{{$coach->name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="coach">Coach</label>
                    </div>
                    <div class="form-group">
                        <select id="specialists" class="specialists" name="specialists[]" multiple="multiple" data-placeholder="Specialists" style="width: 66.67%">
                        </select>
                        <label class="control-label select-label" for="specialist">Specialists</label>
                    </div>
                    <div class="form-group">
                        <select class="agents" name="agent" data-placeholder="Agent" style="width: 66.67%">
                            <option></option>
                            @foreach($data['agents'] as $agent)
                                <option value="{{$agent->id}}"
                                        @if($data['call']->custom_agent_id == $agent->id)
                                        selected
                                        @endif
                                >{{$agent->agent_name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="agent">Agent</label>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary btn-submit" value="Save">
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteCallModal">Delete Call</button>
            </form>
            @endif
        </div>
    </div>
    @include('admin/modals/alert_modal', ['title' => 'Delete Call: '.$data['call']->id, 'formRoute' => route('deleteCall'), 'hiddenValues' => ['call_id' => $data['call']->id], 'modalId' => 'deleteCallModal'])
@endsection