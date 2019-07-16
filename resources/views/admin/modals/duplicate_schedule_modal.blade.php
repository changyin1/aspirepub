<!-- Modal -->
<div class="modal fade" id="duplicateScheduleModal" tabindex="-1" role="dialog" aria-labelledby="duplicateScheduleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Duplicate Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-schedule-form" class="modal-form duplicate-form" action="{{route('duplicateSchedule')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-body">
                        <input type="hidden" id="schedule_id" name="schedule_id" value="{{array_key_exists('schedule', $data) ? $data['schedule']->id : 'null'}}">
                        <div class="form-group">
                            <select class="month" name="month" data-placeholder="Month" style="width: 100%">
                                <option></option>
                                @foreach(range(1,12) as $month)
                                    <option value="{{$month}}">{{DateTime::createFromFormat('!m', $month)->format('F')}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="month">Month</label>
                        </div>
                        <div class="form-group">
                            <input name="year" id="year" class="form-control" type="number" value="2019">
                            <label class="control-label" for="year">Year</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="maintainAssignees">
                            <label class="control-label">Keep call assignments (coaches)</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <input type="submit" class="btn btn-primary btn-submit">
                </div>
            </form>
        </div>
    </div>
</div>