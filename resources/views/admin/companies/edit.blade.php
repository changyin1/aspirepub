@extends('admin.admin_base')

@section('content')
    <div class="admin-page companies-page mt-4">
        <h2>Company: {{$data['company']->name}}</h2>
        <div>
            <form id="update-client-form" class="edit-form" action="{{route('admin/companies/update', ['id' => $data['company']->id])}}" method="post">
                @csrf
                <br>
                <div class="form-body">
                    <input type="hidden" name="id" value="{{$data['company']->id}}">
                    <div class="error">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                        @if($data['save'])
                            <div class="alert alert-primary">Changes successfully saved!</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input name="name" id="name" class="form-control" type="text" value="{{$data['company']->name}}">
                        <label class="control-label" for="question">Name</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-submit" value="Update">
                    </div>
                </div>
            </form>
        </div>
        <div class="client-list">
            <table>
                @if($data['company']->clients->isEmpty())
                    No Clients Assigned to this company
                @else
                    <thead>
                    <tr>
                        <th>Client</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['company']->clients() as $client)
                        <tr data-id="{{$client->id}}">
                            <td>{{$client->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
@endsection