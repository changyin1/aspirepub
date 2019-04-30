@extends('admin.admin_base')

@section('content')
    <div class="admin-page calls-page mt-4">
        <h2>Call {{$data['call']->id}}</h2>
        <div class="call">
            <h5>Client</h5>
            <p><a href="{{route('admin/clients') . '/'.$data['call']->client_id}}">{{$data['call']->client_name()}}</a></p>
            <h5>Schedule</h5>
            <p><a href="{{route('admin/schedules') . '/' .$data['call']->schedule->id}}}">{{$data['call']->schedule->id}}</a></p>
            <h5>Completed</h5>
            <p>{{$data['call']->completed_at ? $data['call']->completed_at . ' by : ' . $data['call']->call_specialist()->name : 'Not complete'}}</p>
            <h5>Due Date</h5>
            <p>{{$data['call']->due_date}}</p>
            @if(!$data['call']->completed_at)
            <form id="edit-schedule-form" class="edit-form ajax" action="{{route('assignCall')}}" method="post">
                @csrf
                <div class="errors" style="width: 66.67%"></div>
                <input type="hidden" id="schedule-id" value="{{$data['call']->schedule->id}}">
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
                        <select class="specialists" name="specialists[]" multiple="multiple" data-placeholder="Specialists" style="width: 66.67%">
                        </select>
                        <label class="control-label select-label" for="specialist">Specialists</label>
                    </div>
                </div>
                <input type="submit" class="btn btn-primary btn-submit" value="Save">
                <input type="submit" class="btn btn-danger btn-delete" value="Delete">
            </form>
            @endif
        </div>
        <script>
            var specialists = [];
            @foreach($data['call']->assigned as $assigned)
                specialists.push({{$assigned->specialist_id}});
            @endforeach
            $(".specialists").val(specialists);
        </script>
    </div>
@endsection