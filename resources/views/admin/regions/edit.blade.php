@extends('admin.admin_base')

@section('content')
    <div class="admin-page region-page mt-4">
        <h2>Region: {{$data['region']->name}}</h2>
        <div>
            <form id="update-region-form" class="edit-form" action="{{route('admin/regions/update', ['id' => $data['region']->id])}}" method="post">
                @csrf
                <br>
                <div class="form-body">
                    <input type="hidden" name="id" value="{{$data['region']->id}}">
                    <div class="error">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                        @if($data['save'])
                            <div class="alert alert-primary">Changes successfully saved!</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input name="name" id="name" class="form-control" type="text" value="{{$data['region']->name}}">
                        <label class="control-label" for="question">Name</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-submit" value="Update">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection