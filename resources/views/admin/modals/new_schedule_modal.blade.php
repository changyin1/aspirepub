<!-- Modal -->
<div class="modal fade" id="newScheduleModal" tabindex="-1" role="dialog" aria-labelledby="newScheduleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-schedule-form" class="modal-form" action="{{route('createSchedule')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-body">
                        <div class="form-group">
                            <select class="client" name="client" data-placeholder="Client" style="width: 100%">
                                <option></option>
                                @foreach($data['clients'] as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="client">Client</label>
                        </div>
                        <div class="form-group">
                            <select class="template" name="template" data-placeholder="Template" style="width: 100%">
                                <option></option>
                                @foreach($data['templates'] as $template)
                                    <option value="{{$template->id}}">{{$template->template_name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="month">Question Template</label>
                        </div>
                        <div class="form-group">
                            <select class="type" name="type" data-placeholder="Call Type" style="width: 100%">
                                <option></option>
                                @foreach($data['types'] as $type)
                                    <option value="{{$type->id}}">{{$type->type}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="type">Call Type</label>
                        </div>
                        <div class="form-group">
                            <select class="language" name="language" data-placeholder="Language" style="width: 100%">
                                <option></option>
                                @foreach($data['languages'] as $language)
                                    <option value="{{$language->language}}">{{$language->language}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="language">Language</label>
                        </div>
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
                            <label class="control-label" for="notes">Notes</label>
                            <textarea class="form-control" name="notes" rows="5" placeholder="Type notes here..."></textarea>
                        </div>
                        </div>
                        <div class="form-group">
                            <input name="year" id="year" class="form-control" type="number" value="2019">
                            <label class="control-label" for="year">Year</label>
                        </div>
                        <div class="form-group">
                            <input name="calls" id="calls" class="form-control" type="number" value="1">
                            <label class="control-label" for="calls">Calls</label>
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