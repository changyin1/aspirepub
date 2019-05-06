@extends('admin.admin_base')

@section('content')
    <div class="admin-page client-page mt-4">
        <h2>Editing Client: {{$data['client']->name}}</h2>
        <div class="client-form">
            <form id="edit-question-form" class="edit-form" action="{{route('admin/clients/edit', ['id' => $data['client']->id])}}" method="post">
                @csrf
                <br>
                <div class="form-body">
                    <input type="hidden" name="id" value="{{$data['client']->id}}">
                    <div class="error">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                        @if($data['save'])
                            <div class="alert alert-primary">Changes successfully saved!</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <input name="name" id="name" class="form-control" type="text" value="{{$data['client']->name}}">
                        <label class="control-label" for="name">Name</label>
                    </div>
                    <div class="form-group">
                        <input name="city" id="city" class="form-control" type="text" value="{{$data['client']->city}}">
                        <label class="control-label" for="city">City</label>
                    </div>
                    <div class="form-group">
                        <input name="country" id="country" class="form-control" type="text" value="{{$data['client']->country}}">
                        <label class="control-label" for="country">Country</label>
                    </div>
                    <div class="form-group">
                        <input name="phone" id="phone" class="form-control" type="text" value="{{$data['client']->phone_number}}">
                        <label class="control-label" for="phone">Phone Number</label>
                    </div>
                    <div class="form-group">
                        <input name="reservation_contact" id="reservation_contact" class="form-control" type="text" value="{{$data['client']->reservation_contact}}">
                        <label class="control-label" for="reservation_contact">Reservation Contact</label>
                    </div>
                    <div class="form-group">
                        <input name="cancellation_email" id="cancellation_email" class="form-control" type="text" value="{{$data['client']->cancellation_email}}">
                        <label class="control-label" for="cancellation_email">Cancellation Email</label>
                    </div>
                    <div class="form-group">
                        <select class="company" name="company" data-placeholder="Company" style="width: 100%">
                            <option></option>
                            <option value="null">None</option>
                            @foreach($data['companies'] as $company)
                                <option value="{{$company->id}}"
                                        @if($data['client']->company_id == $company->id)
                                        selected
                                        @endif
                                >{{$company->name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="company">Company</label>
                    </div>
                    <div class="form-group">
                        <select class="region" name="region" data-placeholder="Region" style="width: 100%">
                            <option></option>
                            <option value="null">None</option>
                            @foreach($data['regions'] as $region)
                                <option value="{{$region->id}}"
                                        @if($data['client']->region_id == $region->id)
                                        selected
                                        @endif
                                >{{$region->name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="region">Region</label>
                    </div>
                    <div class="form-group">
                        <select class="category" name="category" data-placeholder="Category" style="width: 100%">
                            <option></option>
                            <option value="null">None</option>
                            @foreach($data['categories'] as $category)
                                <option value="{{$category->id}}"
                                        @if($data['client']->category_id == $category->id)
                                        selected
                                        @endif
                                >{{$category->name}}</option>
                            @endforeach
                        </select>
                        <label class="control-label select-label" for="category">Category</label>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-submit" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection