@extends('admin.admin_base')

@section('content')
    <div class="admin-page calls-page mt-4">
        <h2>Call {{$data['call']->id}}</h2>
        <div class="call">
            <h5>Client</h5>
            <p>{{$data['call']->client_name()}}</p>
            <h5>Schedule</h5>
            <p>{{$data['call']->schedule->id}}</p>
            <h5>Completed</h5>
            <p>{{$data['call']->completed_at ? $data['call']->completed_at : 'Not complete'}}</p>

            @if(!$data['call']->completed_at)
            <form id="edit-schedule-form" class="edit-form ajax" action="{{route('assignCall')}}" method="post">
                @csrf
                <div class="errors" style="width: 66.67%"></div>
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
                            @foreach($data['specialists'] as $specialist)
                                <option value="{{$specialist->id}}"
                                        @if($data['call']->call_specialist == $specialist->id)
                                        selected
                                        @endif
                                >{{$specialist->name}}</option>
                            @endforeach
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
            console.log(specialists);
            $(".specialists").val(specialists);
        </script>
    </div>
@endsection