@extends('admin.admin_base')

@section('content')
    <div class="admin-page mt-4">
        <h2>Call Reports</h2>
        <div>
            <h5 class="float-left">Quick Stats</h5>
            <table>
                @if($data['calls']['all']->isEmpty())
                    No Calls Scheduled or Completed!
                @else
                    <thead>
                    <tr>
                        <th>Time Period</th>
                        <th>Total Count</th>
                        <th>To Be Completed</th>
                        <th>To Be Scored</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>This Week</td>
                            <td>{{$data['calls']['week']->count()}}</td>
                            <td>{{$data['toBeCompleted']['week']->count()}}</td>
                            <td>{{$data['toBeScored']['week']->count()}}</td>
                        </tr>
                        <tr>
                            <td>This Month</td>
                            <td>{{$data['calls']['month']->count()}}</td>
                            <td>{{$data['toBeCompleted']['month']->count()}}</td>
                            <td>{{$data['toBeScored']['month']->count()}}</td>
                        </tr>
                        <tr>
                            <td>All Time</td>
                            <td>{{$data['calls']['all']->count()}}</td>
                            <td>{{$data['toBeCompleted']['all']->count()}}</td>
                            <td>{{$data['toBeScored']['all']->count()}}</td>
                        </tr>
                    </tbody>
                @endif
            </table>
        </div>
        <br>
        <div>
            <a href="{{route('admin/reports/incomplete')}}/week"><button class="btn btn-primary mr-2">To Be Completed</button></a>
            <a href="{{route('admin/reports/unscored')}}/week"><button class="btn btn-primary">To Be Scored</button></a>
        </div>
    </div>
@endsection