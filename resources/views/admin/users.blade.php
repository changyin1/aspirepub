@extends('admin.admin_base')

@section('content')
    <div class="admin-page mt-4">
        <h2>Users</h2>
        <div>
            <h5 class="float-left">Here are your users</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#newUserModal">
                Create New
            </button>
            <div class="clear"></div>
        </div>
        <div class="user-list">
            <table class="data-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['users'] as $user)
                    <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->role}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td><a href="{{route('admin/users').'/'.$user->id}}">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @include('admin/modals/new_user_modal')
@endsection