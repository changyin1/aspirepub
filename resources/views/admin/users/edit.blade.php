@extends('admin.admin_base')

@section('content')
    <div class="admin-page user-page mt-4">
        <h2>User: {{$data['user']->name}}</h2>
        <div>
            <form id="update-region-form" class="edit-form" action="{{route('admin/users/update', ['id' => $data['user']->id])}}" method="post">
                @csrf
                <br>
                <div class="form-body">
                    <input type="hidden" name="id" value="{{$data['user']->id}}">
                    <div class="error">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                        @if($data['save'])
                            <div class="alert alert-primary">Changes successfully saved!</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input name="name" id="name" class="form-control" type="text" value="{{$data['user']->name}}">
                        <label class="control-label" for="name">Name</label>
                    </div>
                    <div class="form-group">
                        <input name="email" id="email" class="form-control" type="text" value="{{$data['user']->email}}">
                        <label class="control-label" for="email">Email</label>
                    </div>
                    <div class="form-group">
                        <input name="password" id="password" class="form-control" type="text">
                        <label class="control-label" for="password">Password</label>
                    </div>
                    <div class="form-group">
                        <select class="role" name="role" data-placeholder="Role" style="width: 100%">
                            <option></option>
                            <option value="admin"
                                    @if($data['user']->role == 'admin')
                                    selected
                                    @endif
                            >Admin</option>
                            <option value="coach"
                                    @if($data['user']->role == 'coach')
                                    selected
                                    @endif
                            >Coach</option>
                            <option value="call_specialist"
                                    @if($data['user']->role == 'call_specialist')
                                    selected
                                    @endif
                            >Call Specialist</option>
                        </select>
                        <label class="control-label select-label" for="role">Role</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-submit" value="Update">
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteUserModal">
                            Delete User
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @include('admin/modals/alert_modal', ['title' => 'Delete User: '.$data['user']->email, 'formRoute' => route('deleteUser'), 'hiddenValues' => ['user_id' => $data['user']->id], 'modalId' => 'deleteUserModal'])
@endsection