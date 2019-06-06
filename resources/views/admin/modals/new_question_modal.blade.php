<!-- Modal -->
<div class="modal fade" id="newQuestionModal" tabindex="-1" role="dialog" aria-labelledby="newQuestionModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newQuestionModalLabel">Create New Question</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-question-form" class="modal-form" action="{{route('createQuestion')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-body">
                        <div class="form-group">
                            <input name="question" id="question" class="form-control" type="text" value="">
                            <label class="control-label" for="question">Question</label>
                        </div>
                        <div class="form-group">
                            <select class="type" name="type" data-placeholder="Type" style="width: 100%">
                                <option></option>
                                <option value="Normal">Normal</option>
                                <option value="Yes/No">Yes/No</option>
                                <option value="Bonus">Bonus</option>
                            </select>
                            <label class="control-label select-label" for="type">Type</label>
                        </div>
                        <div class="form-group">
                            <select class="type" name="client" data-placeholder="Client" style="width: 100%">
                                <option></option>
                                @foreach($data['clients'] as $client)
                                    <option value="{{$client->id}}">{{$client->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="client">Client</label>
                        </div>
                        <div class="form-group">
                            <select class="type" name="company" data-placeholder="Company" style="width: 100%">
                                <option></option>
                                @foreach($data['companies'] as $company)
                                    <option value="{{$company->id}}">{{$company->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="company">Company</label>
                        </div>
                        <div class="form-group">
                            <select class="type" name="region" data-placeholder="Region" style="width: 100%">
                                <option></option>
                                @foreach($data['regions'] as $region)
                                    <option value="{{$region->id}}">{{$region->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="region">Region</label>
                        </div>
                        <div class="form-group">
                            <input name="weight" id="weight" class="form-control" type="number" value="10">
                            <label class="control-label" for="weight">Weight</label>
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