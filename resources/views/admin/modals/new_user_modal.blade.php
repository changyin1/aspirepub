<!-- Modal -->
<div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Schedule</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="create-user-form" class="modal-form" action="{{route('createUser')}}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="errors"></div>
                    <div class="form-body">
                        <div class="form-group">
                            <input name="name" id="name" class="form-control" type="text">
                            <label class="control-label" for="name">Name</label>
                        </div>
                        <div class="form-group">
                            <input name="email" id="email" class="form-control" type="text">
                            <label class="control-label" for="email">Email</label>
                        </div>
                        <div class="form-group">
                            <input name="password" id="password" class="form-control" type="text">
                            <label class="control-label" for="password">Password</label>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" id="grandfathered" name="grandfathered">
                            <label class="control-label" for="grandfathered">Grandfathered In</label>
                        </div>
                        <div class="form-group">
                            <select class="role" name="role" data-placeholder="Role" style="width: 100%">
                                <option></option>
                                <option value="admin">Admin</option>
                                <option value="coach">Coach</option>
                                <option value="call_specialist">Call Specialist</option>
                            </select>
                            <label class="control-label select-label" for="role">Role</label>
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