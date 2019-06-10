<!-- Modal -->
<div class="modal fade" id="newCallTypeModal" tabindex="-1" role="dialog" aria-labelledby="newCallTypeModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newQuestionModalLabel">Create New Call Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-call-type-form" class="modal-form" action="{{route('createCallType')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-body">
                        <div class="form-group">
                            <input name="type" id="type" class="form-control" type="text" value="">
                            <label class="control-label" for="type">Call Type</label>
                        </div>
                    </div>
                    <div class="form-body">
                        <div class="form-group">
                            <input name="price" id="price" class="form-control" price="text" value="">
                            <label class="control-label" for="price">Type price</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <input type="submit" class="btn btn-primary btn-submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>