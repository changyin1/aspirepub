@extends('admin.admin_base')

@section('content')
    <div class="admin-page companies-page mt-4">
        <h2>Company: {{$data['company']->name}}</h2>
        <div class="company-list">
            <div class="error"></div>
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