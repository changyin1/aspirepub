<form id="edit-schedule-form" class="edit-form ajax" action="{{route('modifySchedule')}}" method="post">
    @csrf
    <div class="errors" style="width: 66.67%"></div>
    <div class="form-body">
        <input type="hidden" name="schedule_id" id="schedule_id" value="{{$data['schedule']->id}}">
        <input type="hidden" name="finalized" id="finalized" value="0">
        <div class="form-group">
            <select class="client" name="client" data-placeholder="Client" style="width: 66.67%">
                <option></option>
                @foreach($data['clients'] as $client)
                    <option value="{{$client->id}}"
                            @if($data['schedule']->client_id == $client->id)
                            selected
                            @endif
                    >{{$client->name}}</option>
                @endforeach
            </select>
            <label class="control-label select-label" for="client">Client</label>
        </div>
        <div class="form-group">
            <select class="template" name="template" data-placeholder="Template" style="width: 66.67%">
                <option></option>
                @foreach($data['templates'] as $template)
                    <option value="{{$template->id}}"
                            @if($data['schedule']->questionstemplates_id == $template->id)
                            selected
                            @endif
                    >{{$template->template_name}}</option>
                @endforeach
            </select>
            <label class="control-label select-label" for="month">Question Template</label>
        </div>
        <div class="form-row">
            <div class="form-group col-4">
                <select class="month" name="month" data-placeholder="Month" style="width: 100%">
                    <option></option>
                    @foreach(range(1,12) as $month)
                        <option value="{{$month}}"
                                @if(Carbon\Carbon::parse($data['schedule']->start_date)->format('n') == $month)
                                selected
                                @endif
                        >{{DateTime::createFromFormat('!m', $month)->format('F')}}</option>
                    @endforeach
                </select>
                <label class="control-label select-label" for="month">Month</label>
            </div>
            <div class="form-group col-4">
                <input name="year" id="year" class="form-control" type="number" value="{{Carbon\Carbon::parse($data['schedule']->start_date)->format('Y')}}">
                <label class="control-label" for="year">Year</label>
            </div>
        </div>
        <div class="form-group" style="width: 66.67%">
            <input name="calls" id="calls" class="form-control" type="number" value="{{$data['schedule']->calls}}">
            <label class="control-label" for="calls">Calls</label>
        </div>
        <input type="submit" data-message="Once you have finalized you can no longer edit are you sure you want to finalize this schedule?" class="btn btn-primary btn-submit submit-alert" data-field="finalized" value="Finalize">
        <input type="submit" class="btn btn-primary btn-submit" value="Save">
        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteScheduleModal">
            Delete
        </button>
    </div>
</form>