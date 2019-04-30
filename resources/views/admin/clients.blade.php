@extends('admin.admin_base')

@section('content')
    <div class="admin-page clients-page mt-4">
        <h2>Clients</h2>
        <div>
            <h5 class="float-left">Here are your clients</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal"
                    data-target="#newClientModal">
                Create New
            </button>
            <div class="clear"></div>
        </div>
        <div class="client-list">
            @if($data['clients']->isEmpty())
                No Clients Created Add One to Get Started!
            @else
                <table class="data-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>City</th>
                        <th>Country</th>
                        <th>Reservation Contact</th>
                        <th>Cancellation Email</th>
                        <th>Company</th>
                        <th>Region</th>
                        <th>Category</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['clients'] as $client)
                        <tr class="link-row" data-href="{{route('admin/clients') . '/'.$client->id}}">
                            <td>{{$client->name}}</td>
                            <td>{{$client->city}}</td>
                            <td>{{$client->country}}</td>
                            <td>{{$client->reservation_contact}}</td>
                            <td>{{$client->cancellation_email}}</td>
                            <td>{{$client->company ? $client->company->name : ''}}</td>
                            <td>{{$client->region ? $client->region->name : ''}}</td>
                            <td>{{$client->category ? $client->category->name : ''}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @include('admin/modals/new_client_modal')
@endsection