@extends('admin.admin_base')

@section('content')
    <div class="admin-page mt-4">
        <h2>Schedules</h2>
        <div class="schedule-list">
            <table>
                @if(!$data['schedules'])
                    No Schedules Created Click Here to Add One!
                @else
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Number of Calls</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['schedules'] as $schedule)
                        <tr>
                            <td>{{$schedule->id}}</td>
                            <td>{{$schedule->client_name()}}</td>
                            <td>{{date_format($schedule->start_date, 'F Y')}}</td>
                            <td>{{$schedule->calls}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
@endsection