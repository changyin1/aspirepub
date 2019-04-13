@extends('admin.admin_base')

@section('content')
    <div class="admin-page category-page mt-4">
        <h2>Category: {{$data['category']->name}}</h2>
        <div>
            <form id="update-category-form" class="edit-form" action="{{route('admin/categories/update', ['id' => $data['category']->id])}}" method="post">
                @csrf
                <br>
                <div class="form-body">
                    <input type="hidden" name="id" value="{{$data['category']->id}}">
                    <div class="error">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                        @if($data['save'])
                            <div class="alert alert-primary">Changes successfully saved!</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input name="name" id="name" class="form-control" type="text" value="{{$data['category']->name}}">
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