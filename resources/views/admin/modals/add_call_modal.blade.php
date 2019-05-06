<!-- Modal -->
<div class="modal fade" id="addCallModal" tabindex="-1" role="dialog" aria-labelledby="addCallModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add calls to this schedule!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-schedule-form" class="modal-form" action="{{route('addCalls')}}" method="post">
                @csrf
                <input type="hidden" name="schedule_id" value="{{$data['schedule']->id}}">
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-group">
                        <input class="form-control" type="number" name="number" id="number">
                        <label class="control-label" for="number">Number of Calls</label>
                    </div>
                    <div class="form-group">
                        <select class="week" name="week" data-placeholder="Week" style="width: 100%">
                            <option></option>
                            @foreach(range(1, 4) as $week)
                                <option value="{{$week}}">{{$week}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="week">Week</label>
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