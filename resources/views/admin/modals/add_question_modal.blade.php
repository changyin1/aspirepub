<!-- Modal -->
<div class="modal fade" id="addQuestionToTemplateModal" role="dialog" aria-labelledby="addQuestionToTemplateModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add a question to this template!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-schedule-form" class="modal-form" action="{{route('addQuestionToTemplate')}}" method="post">
                @csrf
                <input type="hidden" name="template_id" value="{{$data['template']->id}}">
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-group">
                        <select class="client" name="client" data-placeholder="Client" style="width: 100%">
                            <option></option>
                            <option value=" ">Any</option>
                            @foreach($data['clients'] as $client)
                                <option value="{{$client->id}}">{{$client->name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="client">Client</label>
                    </div>
                    <div class="form-group">
                        <select class="company" name="company" data-placeholder="Company" style="width: 100%">
                            <option></option>
                            <option value=" ">Any</option>
                            @foreach($data['companies'] as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="company">Company</label>
                    </div>
                    <div class="form-group">
                        <select class="region" name="region" data-placeholder="Region" style="width: 100%">
                            <option></option>
                            <option value=" ">Any</option>
                            @foreach($data['regions'] as $region)
                                <option value="{{$region->id}}">{{$region->name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="region">Region</label>
                    </div>
                    <div class="form-group">
                        <select class="question searchable" name="question[]" multiple="multiple" data-placeholder="Question" style="width: 100%">
                            <option></option>
                            @foreach($data['questions'] as $question)
                                <option value="{{$question->id}}" client="{{$question->client}}" company="{{$question->company}}" region="{{$question->region}}">{{$question->question}} (Weight: {{$question->weight}})</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="question">Question</label>
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