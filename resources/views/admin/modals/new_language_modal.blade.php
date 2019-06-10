<!-- Modal -->
<div class="modal fade" id="newLanguageModal" tabindex="-1" role="dialog" aria-labelledby="newLanguageModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newQuestionModalLabel">Create New Language</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-language-form" class="modal-form" action="{{route('createLanguage')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-body">
                        <div class="form-group">
                            <input name="language" id="language" class="form-control" type="text" value="">
                            <label class="control-label" for="language">Language</label>
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