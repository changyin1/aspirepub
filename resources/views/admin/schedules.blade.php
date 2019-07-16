@extends('admin.admin_base')

@section('content')
    <div class="admin-page schedules-page mt-4">
        <h2>Schedules</h2>
        <div>
            <h5 class="float-left">Here are your schedules</h5>
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#newScheduleModal">
                Create New
            </button>
            <button class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#duplicateScheduleModal">Duplicate Selected</button>
            <div class="clear"></div>
        </div>
        <div class="schedule-list">
            <table class="data-table" data-searchable="false">
                @if($data['schedules']->isEmpty())
                    No Schedules Created Add One to Get Started!
                @else
                    <thead>
                    <tr>
                        <th><input class="checkbox-all" type="checkbox"></th>
                        <th>#</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Question Template</th>
                        <th>Number of Calls</th>
                        <th>Finalized</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data['schedules'] as $schedule)
                        <tr class="checkbox-row" data-href="{{route('admin/schedules') . '/'.$schedule->id}}">
                            <td><input class="checkbox" type="checkbox" name="schedule-id" value="{{$schedule->id}}"></td>
                            <td>{{$schedule->id}}</td>
                            <td>{{$schedule->client_name()}}</td>
                            <td>{{date_format($schedule->start_date, 'Y-m')}}</td>
                            <td>{{$schedule->template_name()}}</td>
                            <td>{{$schedule->calls}}</td>
                            <td>{{$schedule->finalized ? 'Yes' : 'No'}}</td>
                            <td><a href="{{route('admin/schedules') . '/'.$schedule->id}}}}">Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
    @include('admin/modals/new_schedule_modal')
    @include('admin/modals/duplicate_schedule_modal')
@endsection