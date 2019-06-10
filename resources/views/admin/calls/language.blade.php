@extends('admin.admin_base')

@section('content')
    <div class="admin-page language-page mt-4">
        <h2>{{$data['language']->language}}</h2>
        <form id="edit-question-form" class="edit-form" action="{{route('admin/language/edit', ['id' => $data['language']->id])}}" method="post">
            @csrf
            <br>
            <div class="form-body">
                <input type="hidden" name="id" value="{{$data['language']->id}}">
                <div class="error">
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger">{{$error}}</div>
                    @endforeach
                    @if($data['save'])
                        <div class="alert alert-primary">Changes successfully saved!</div>
                    @endif
                </div>
                <div class="form-group">
                    <input name="language" id="language" class="form-control" type="text" value="{{$data['language']->language}}">
                    <label class="control-label" for="language">Language</label>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-submit" value="Save">
                </div>
            </div>
        </form>
    </div>
@endsection