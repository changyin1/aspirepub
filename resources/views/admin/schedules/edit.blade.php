@extends('admin.admin_base')

@section('content')
    <div class="admin-page schedules-page mt-4">
        <h2>Schedule {{$data['schedule']->id}}</h2>
        <div class="schedule">
            @if($data['edit'])
                <div class="error"></div>
                @include('admin.schedules.edit_form')
            @else
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-2">
                            <div class="detail-name">Client:</div>
                            <div class="detail-name">Start Date:</div>
                            <div class="detail-name">Calls:</div>
                        </div>
                        <div class="col-3">
                            <div class="detail">{{$data['schedule']->client_name()}}</div>
                            <div class="detail">{{Carbon\Carbon::parse($data['schedule']->start_date)->format('M-d-Y')}}</div>
                            <div class="detail">{{$data['schedule']->calls}}</div>
                        </div>
                    </div>

                </div>
                </table>
            @endif
        </div>
    </div>
@endsection