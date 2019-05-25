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
                        <select class="question searchable" name="question" data-placeholder="Question" style="width: 100%">
                            <option></option>
                            @foreach($data['questions'] as $question)
                                <option value="{{$question->id}}">{{$question->question}}</option>
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