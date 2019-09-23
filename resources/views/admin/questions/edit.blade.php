@extends('admin.admin_base')

@section('content')
    <div class="admin-page questions-page mt-4">
        <h2>Editing Question: {{$data['question']->id}}</h2>
        <div class="question-form">
            @if($data['templates'])
                <div class="template-list">
                    <h5>Currently used in the following templates:</h5>
                @foreach($data['templates'] as $template)
                    <li>{{$template->template_name}}</li>
                @endforeach
                </div>
            @endif
            <form id="edit-question-form" class="edit-form" action="{{route('admin/questions/edit', ['id' => $data['question']->id])}}" method="post">
                @csrf
                <br>
                <div class="form-body">
                    <input type="hidden" name="id" value="{{$data['question']->id}}">
                    <div class="error">
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{$error}}</div>
                        @endforeach
                        @if($data['save'])
                            <div class="alert alert-primary">Changes successfully saved!</div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="control-label textarea-label" for="question">Question</label>
                        <textarea name="question" id="question" class="form-control" rows="5">{{$data['question']->question}}</textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6">
                            <select class="type" name="type" data-placeholder="Type" style="width: 100%">
                                <option></option>
                                <option value="Normal"
                                        @if($data['question']->type == 'Normal')
                                        selected
                                        @endif
                                >Normal</option>
                                <option value="Yes/No"
                                        @if($data['question']->type == 'Yes/No')
                                        selected
                                        @endif
                                >Yes/No</option>
                                <option value="Bonus"
                                        @if($data['question']->type == 'Bonus')
                                        selected
                                        @endif
                                >Bonus</option>
                            </select>
                            <label class="control-label select-label" for="type">Type</label>
                        </div>
                        <div class="form-group col-6">
                            <input name="weight" id="weight" class="form-control" type="number" value="{{$data['question']->weight}}">
                            <label class="control-label" for="weight">Weight</label>
                        </div>
                        <div class="form-group col-6">
                            <select class="type" name="client" data-placeholder="Client" style="width: 100%">
                                <option></option>
                                <option value="0">None</option>
                                @foreach($data['clients'] as $client)
                                    <option value="{{$client->id}}"
                                            @if($data['question']->client == $client->id)
                                            selected
                                            @endif
                                    >{{$client->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="client">Client</label>
                        </div>
                        <div class="form-group col-6">
                            <select class="type" name="company" data-placeholder="Company" style="width: 100%">
                                <option></option>
                                <option value="0">None</option>
                                @foreach($data['companies'] as $company)
                                    <option value="{{$company->id}}"
                                            @if($data['question']->company == $company->id)
                                            selected
                                            @endif
                                    >{{$company->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="company">Company</label>
                        </div>
                        <div class="form-group col-6">
                            <select class="type" name="region" data-placeholder="Region" style="width: 100%">
                                <option></option>
                                <option value="0">None</option>
                                @foreach($data['regions'] as $region)
                                    <option value="{{$region->id}}"
                                            @if($data['question']->region == $region->id)
                                            selected
                                            @endif
                                    >{{$region->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="region">Region</label>
                        </div>
                        <div class="form-group col-6">
                            <select class="category" name="category" data-placeholder="Category" style="width: 100%">
                                <option></option>
                                <option value=" ">Any</option>
                                @foreach($data['categories'] as $category)
                                    <option value="{{$category->id}}"
                                            @if($data['question']->category == $category->id)
                                            selected
                                            @endif
                                    >{{$category->name}}</option>
                                @endforeach
                            </select>
                            <label class="control-label select-label" for="category">Category</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary btn-submit" value="Save">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection