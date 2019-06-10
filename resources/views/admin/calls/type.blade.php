@extends('admin.admin_base')

@section('content')
    <div class="admin-page type-page mt-4">
        <h2>{{$data['type']->type}}</h2>
        <form id="edit-question-form" class="edit-form" action="{{route('admin/call/type/edit', ['id' => $data['type']->id])}}" method="post">
            @csrf
            <br>
            <div class="form-body">
                <input type="hidden" name="id" value="{{$data['type']->id}}">
                <div class="error">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @if($data['save'])
                        <div class="alert alert-primary">Changes successfully saved!</div>
                    @endif
                </div>
                <div class="form-group">
                    <input name="type" id="type" class="form-control" type="text" value="{{$data['type']->type}}">
                    <label class="control-label" for="type">Call Type</label>
                </div>
                <div class="form-group">
                    <input name="price" id="price" class="form-control" price="text" value="{{$data['type']->price}}">
                    <label class="control-label" for="price">Type price</label>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-submit" value="Save">
                </div>
            </div>
        </form>
    </div>
@endsection