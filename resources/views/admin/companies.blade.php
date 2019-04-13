@extends('admin.admin_base')

@section('content')
    <div class="admin-page companies-page mt-4">
        <h2>Companies</h2>
        <div>
            <h5 class="float-left">Here are your companies</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#newCompanyModal">
                Create New
            </button>
            <div class="clear"></div>
        </div>
        <div class="company-list">
            @if($data['companies']->isEmpty())
                No Companies Created Add One to Get Started!
            @else
                <table class="data-table" data-searchable="false">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['companies'] as $company)
                        <tr class="link-row" data-href="{{route('admin/companies') . '/'.$company->id}}">
                            <td>{{$company->id}}</td>
                            <td>{{$company->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @include('admin/modals/new_company_modal')
@endsection