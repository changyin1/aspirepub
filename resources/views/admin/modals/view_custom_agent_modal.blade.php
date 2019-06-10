<!-- Modal -->
<div class="modal fade" id="viewCustomAgentModal" tabindex="-1" role="dialog" aria-labelledby="viewCustomAgentModal"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit custom agents for this schedule!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="edit-custom-agents-form" class="modal-form" action="{{route('modifyAgents')}}" method="post">
                @csrf
                <input type="hidden" name="schedule_id" value="{{$data['schedule']->id}}">
                <input type="hidden" name="type" value="add">
                <div class="modal-body">
                    <div class="errors"></div>
                    @if($data['schedule']->customAgents)
                        @foreach($data['schedule']->customAgents as $agent)
                            <div class="form-group">
                                <div class="agent-item" data-agentid="{{$agent->id}}">{{$agent->agent_name}}<span class="float-right"><button class="btn btn-danger btn-remove-agent" type="button">Remove</button></span></div>
                            </div>
                        @endforeach
                    @endif
                    <div class="form-group">
                        <input class="form-control inline-block" type="name" name="name[]" id="name">
                        <label class="control-label" for="name">Agent Name</label>
                        <span><button class="btn btn-success btn-add" type="button">+</button></span>
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