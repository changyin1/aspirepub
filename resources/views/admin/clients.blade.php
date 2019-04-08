@extends('admin.admin_base')

@section('content')
    <div class="admin-page mt-4">
        <h2>Clients</h2>
        <div class="client-list">
            @foreach($data['clients'] as $client)
                <div class="client-container">
                    <h4>{{$client->name}}</h4>
                    <div class="client-details">
                        <div class="client-detail">
                            City: {{$client->city}}
                        </div>
                        <div class="client-detail">
                            Country: {{$client->country}}
                        </div>
                        <div class="client-detail">
                            Contact: {{$client->reservation_contact}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection